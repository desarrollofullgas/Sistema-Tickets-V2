<?php

namespace App\Http\Livewire\Usuarios;

use App\Mail\MailNewUser;
use App\Models\Areas;
use App\Models\Departamento;
use App\Models\Permiso;
use App\Models\Region;
use App\Models\User;
use App\Models\UserArea;
use App\Models\Zona;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

class UserCreate extends Component
{
    public $newgUsuario;
    public $name, $username, $email, $password, $password_confirmation, $permiso,$tel;
    public $zonas, $zonasList;

    //variables para crear usuario que no sea un gerente, supervisor, administrador o compras
    public $selectZonas = false, $personaltck = false;
    public $deptos; //lista de registros
    public $area; //para guardar el valor
    public $region;
    public $areas, $areasList;

    public $areau = false; //es una propiedad pública de tipo booleano que se inicializa en false.
    public $zonau = false; //es una propiedad pública de tipo booleano que se inicializa en false.


    public $currentStep = 1;

    public function resetFilters()
    {
        $this->reset(['name', 'username', 'email', 'password', 'permiso']);
    }

    public function mount()
    {
        $this->zonas = Zona::all();
        $this->areas= Areas::all();
        
        $this->newgUsuario = false;
    }

    public function showModalFormUsuario() //funcion abrir modal 
    {
        $this->resetFilters();

        $this->newgUsuario = true;
    }

    // public function UpdatedPermiso($val)
    // {
    //     if ($val == 1 || $val == 4) {
    //         $this->areau = false;
    //         $this->zonau = false;
    //     } elseif ($val == 5 || $val == 6 || $val == 7 || $val == 8) {
    //         $this->areau = true;
    //         $this->zonau = false;
    //     } elseif ($val == 2 || $val == 3) {
    //         $this->areau = true;
    //         $this->zonau = true;
    //     } else {
    //         // Reinicia los valores al pasar de un valor a otro
    //         $this->areau = false;
    //         $this->zonau = false;
    //     }
    // }


    public function nextStep() //funcion siguiente con validacion
    {
        $this->validate(
            [
                'name' => ['required', 'max:250'],
                'username' => ['required', 'unique:users',  'max:250'],
                'email'=>['required', 'string', 'email', 'max:40',Rule::unique('users')->where(function ($query) {
                    // Agregamos una cláusula where para verificar si el usuario asociado está inactivo
                    $query->where('status', 'Activo'); // Ajusta 'activo' al estado correspondiente en tu base de datos
                }),],
            ],
            [
                'name.required' => 'El campo Nombre es obligatorio',
                'name.max' => 'El campo Nombre no debe ser mayor a 250 carateres',
                'username.required' => 'El campo Usuario es obligatorio',
                'username.max' => 'El campo Usuario no debe ser mayor a 250 carateres',
                'username.unique:users' => 'El campo Usuario ya existe',
                'email.required' => 'El campo Email es obligatorio',
                'email.email' => 'El campo Email debe ser un correo valido',
                'email.max' => 'El campo Email no debe ser mayor a 40 caracteres',
                'email.unique:users' => 'El campo Email ya ha sido registrado',
            ]
        );

        $this->currentStep++;
    }
    public function nextStep2() //funcion 2 siguiente con validacion
    {
        $this->validate(
            [
                'permiso' => ['required', 'not_in:0'],
                'region' => ['required', 'not_in:0'],
            ],
            [
                'permiso.required' => 'El campo Rol es obligatorio',
                'region.required' => 'Seleccione una región para el usuario'
            ]
        );
        $this->currentStep++;
    }

    public function previousStep() //funcion retroceder 
    {
        $this->currentStep--;
    }

    public function addUserTCK() //funcion para crear al usuario
    {

        $usersIs = User::where('permiso_id', 1)->get(); // Usuarios Admin

        $this->validate( //validaciones => campos requerdos
            [
                'name' => ['required', 'max:250'],
                'username' => ['required',  'max:30'],
                'email'=>['required', 'string', 'email', 'max:40',Rule::unique('users')->where(function ($query) {
                    // Agregamos una cláusula where para verificar si el usuario asociado está inactivo
                    $query->where('status', 'Activo'); // Ajusta 'activo' al estado correspondiente en tu base de datos
                }),],
                'password' => ['required', 'string', 'confirmed', Password::min(8)],
                'password_confirmation' => ['required', 'same:password'],
                'permiso' => ['required', 'not_in:0'],
                'region' => ['required', 'not_in:0'],
            ],
            [ // pasamos a español las validaciones
                'name.required' => 'El campo Nombre es obligatorio',
                'name.max' => 'El campo Nombre no debe ser mayor a 250 carateres',
                'username.required' => 'El campo Usuario es obligatorio',
                'username.max' => 'El campo Usuario no debe ser mayor a 250 carateres',
                'email.required' => 'El campo Email es obligatorio',
                'email.email' => 'El campo Email debe ser un correo valido',
                'email.max' => 'El campo Email no debe ser mayor a 40 caracteres',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe ser mayor a 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
                'password_confirmation.required' => 'La contraseña es obligatoria',
                'password_confirmation.same' => 'Las contraseñas no coinciden',
                'permiso.required' => 'El campo Rol es obligatorio',
                'region.required' => 'Seleccione una región para el usuario'
            ]
        );

        $pass = $this->password; //se almacena en otra variable para poder recuperarla antes del hash y poder enviarla al usuario por mail
        $emailuser = $this->email; //se almacena en otra variable para facilitar el reconocimiento al mailer y para envio al usuario

        // Crear al usuario
        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'permiso_id' => $this->permiso,
            'region_id' => $this->region,
            'email' => $this->email,
            'telefono' => $this->tel,
            'password' => Hash::make($this->password),
        ]);

        $user->areas()->sync($this->areasList); // Asignamos área(s) al usuario cuando sean requeridas

        $user->zonas()->sync($this->zonasList); // Asignamos zona(s) al usuario cuando sea requerida

        $ultid = User::latest('id')->first();
        $mailDataU = [ // recolectamos datos para envio de accesos por mail
            'fecha' => $ultid->created_at,
            'usuarioname' => $ultid->name,
            'usuariousername' => $ultid->username,
            'pass' => $pass,
            'numUser' => $ultid->id,
        ];

        Mail::to($emailuser) // reconocemos al usuario creado y le enviamos el correo
            ->cc($usersIs) // no puede haber dos veces el campo bcc/cc (copia oculta) - enviamos copia a admins
            ->bcc(['auxsistemas@fullgas.com.mx','desarrollo@fullgas.com.mx']) // copia a Aux Sistemas
            ->send(new MailNewUser($mailDataU)); // enviamos la vista mail creada pasando los datos almacenados en la variable $mailDataU

        // Alert::success('Nuevo Usuario', "El usuario" . ' ' . $this->name . ' ' . "ha sido agregado al sistema"); 
        session()->flash('flash.banner', 'Nuevo usuario, el usuario "'.$this->name.'" ha sido agregado al sistema.');
        session()->flash('flash.bannerStyle', 'success');

        //return redirect()->route('users'); //Despúes de creado el usuario retornamos a la vista usuarios
		 return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $permisos = Permiso::all(); // Todos los permisos
        $this->deptos = Departamento::select('id', 'name')->orderBy('name', 'asc')->get(); // Departamentos
        $zonas = Zona::where('status', 'Activo')->get(); // Zonas
        $areas = Areas::where('status', 'Activo')->get(); // Areas
        $regiones = Region::where('status', 'Activo')->whereNotIn('id', [3,4])->get(); // Regiones
        return view('livewire.usuarios.user-create', compact('zonas', 'permisos', 'regiones','areas')); // pasamos las variables a renderizar con compact
    }
}
