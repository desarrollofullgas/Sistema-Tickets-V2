<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\Areas;
use App\Models\Departamento;
use App\Models\Permiso;
use App\Models\Region;
use App\Models\User;
use App\Models\UserArea;
use App\Models\Zona;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserEdit extends Component
{
    public $EditUsuario; //es una propiedad pública que se utiliza para controlar si se está editando un usuario o no.

    public $user_edit_id, $name, $username, $email, $role, $status, $password, $password_confirmation, $region,$tel;//son propiedades públicas que almacenan los datos del usuario que se está editando. 
    //Cada una de ellas tiene un tipo específico, como int o string, dependiendo del tipo de dato que se espera para cada campo del usuario.

    public $zonasUpdate = []; //es una propiedad pública que almacena un array vacío y se utiliza para actualizar las zonas del usuario.
    public $areasUpdate = []; //es una propiedad pública que almacena un array vacío y se utiliza para actualizar las areas del usuario.
    public $areau = false; //es una propiedad pública de tipo booleano que se inicializa en false.
    public $zonau = false; //es una propiedad pública de tipo booleano que se inicializa en false.
    public $deptos, $area; //son propiedades públicas que se inicializan sin ningún valor asignado.

    public function resetFilters() //resetea los campos 
    {
        $this->reset(['name', 'username', 'email', 'password', 'role',  'status']);
    }

    public function mount()
    {
        $this->EditUsuario = false; //se establece en false, lo que indica que no se está editando ningún usuario inicialmente.
        $this->zonasUpdate = []; //se establece como un array vacío, lo que significa que no hay ninguna zona seleccionada inicialmente.
        $this->areasUpdate = []; //se establece como un array vacío, lo que significa que no hay ningun area seleccionada inicialmente.
    }

    
    public function UpdatedRole($val)
    {//función para habilitar zonas o areas cuando de acuerdo al rol
        if($val==1 || $val==4){
            $this->areau=false;
            $this->zonau=false;
            $this->zonasUpdate=[];
            $this->areasUpdate=[];
        }
        elseif($val==5 || $val==6 || $val==7 || $val==8){
            $this->areau=true;
            $this->zonau=false;
            $this->zonasUpdate=[];
            $this->areasUpdate=[];
        }
        elseif($val==2 || $val==3){
            $this->areau=true;
            $this->zonau=true;
            $this->zonasUpdate=[];
            $this->areasUpdate=[];
        }
    }

    public function confirmUserEdit(int $id)
    {

        $user = User::where('id', $id)->first(); //Se recupera el usuario correspondiente al ID seleccionado

        $this->user_edit_id = $id; //se recolectan los valores del usuario seleccionado
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->tel = $user->telefono;
        $this->role = $user->permiso->id;
        $this->region = $user->region_id;
        $this->status = $user->status;

        $this->EditUsuario = true; // cambiamos la propiedad a true lo que indica que se esta editando info del usuario (abre el modal).

        $arrayID = [];//Se recopilan los IDs de las zonas asociadas al usuario en un array
        $zonasArray = DB::table('user_zona')->select('zona_id')->where('user_id', $id)->get();
        foreach ($zonasArray as $zona) { //utilizando una consulta de base de datos y un bucle foreach. Los IDs se almacenan en el atributo $zonasUpdate.

            $arrayID[] = $zona->zona_id;
        }
        $this->zonasUpdate = $arrayID; //Esto se utiliza para mostrar y mantener las zonas seleccionadas por el usuario en el formulario de edición.

        $arraycollectID = [];//Se recopilan los IDs de las areas asociadas al usuario en un array
        $areasArray = DB::table('user_areas')->select('area_id')->where('user_id', $id)->get();
        foreach ($areasArray as $area) { //utilizando una consulta de base de datos y un bucle foreach. Los IDs se almacenan en el atributo $areasUpdate.

            $arraycollectID[] = $area->area_id;
        }
        $this->areasUpdate = $arraycollectID; //Esto se utiliza para mostrar y mantener las areas seleccionadas por el usuario en el formulario de edición.
    }

    public function EditarUsuario($id)
    {
        $user = User::where('id', $id)->first(); //Se recupera el usuario correspondiente al ID seleccionado

        //Validación de datos enviados desde el formulario
        $this->validate(
            [
                'name' => ['required', 'string', 'max:250'],
                'username' => ['required', 'string', 'max:250'],
                'email' => ['required', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable', 'string', 'confirmed', Password::min(8)],
                'password_confirmation' => ['same:password'],
                'role' => ['required', 'not_in:0'],
                'status' => ['required', 'not_in:0'],
            ],
            [
                'name.required' => 'El campo Nombre es obligatorio',
                'name.string' => 'El campo Nombre debe ser Texto',
                'name.max' => 'El campo Nombre no debe ser mayor a 250 carateres',
                'username.required' => 'El campo Usuario es obligatorio',
                'username.max' => 'El campo Usuario no debe ser mayor a 250 carateres',
                'email.required' => 'El campo Email es obligatorio',
                'email.email' => 'El campo Email debe ser un correo valido',
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe ser mayor a 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
                'password_confirmation.required' => 'La contraseña es obligatoria',
                'password_confirmation.same' => 'Las contraseñas no coinciden',
                'role.required' => 'El campo Rol es obligatorio',
                'status.required' => 'El campo Status es obligatorio',
            ]
        );

        //Si el campo de correo electrónico ($email) ha sido modificado y el usuario implementa la interfaz MustVerifyEmail, se llama a la función updateVerifiedUser() para actualizar el estado de verificación del usuario.
        if (
            $this->email !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user);
        } else {  //Se utiliza el método forceFill() del modelo de usuario para actualizar los campos name, username, email, permiso_id, region_id y status con los valores proporcionados en el formulario. Luego, se guarda el usuario.
            $user->forceFill([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'telefono'=>$this->tel,
                'permiso_id' => $this->role,
                'region_id' => $this->region,
                'status' => $this->status,
            ])->save();
        }

        //Si se ha proporcionado una nueva contraseña ($password), se utiliza el método forceFill() para actualizar el campo password con la contraseña encriptada. De lo contrario, se actualizan los otros campos del usuario y se guarda.
        if (!empty($this->password)) {
            $user->forceFill([
                'password' => Hash::make($this->password),
            ])->save();
        } else {
            $user->forceFill([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'telefono'=>$this->tel,
                'permiso_id' => $this->role,
                'region_id' => $this->region,
                'status' => $this->status,
            ])->save();
        }

       
        if (isset($user->zonas)){
            $user->zonas()->sync($this->zonasUpdate);
            }else{
                $user->zonas()->sync(array());
            }
        
            if (isset($user->areas)){
                $user->areas()->sync($this->areasUpdate);
                }else{
                    $user->areas()->sync(array());
                }


        $this->resetFilters();//Se restablecen los filtros ($this->resetFilters()) para limpiar los campos del formulario de búsqueda o filtros utilizados antes de la edición.
        //Alert::success('Usuario Actualizado', "El usuario" . ' ' . $this->name . ' ' . "ha sido actualizado en el sistema");//Se muestra una alerta de éxito utilizando la clase Alert, indicando que el usuario ha sido actualizado.
        session()->flash('flash.banner', 'Usuario Actualizado, el usuario "'.$user->name.'" ha sido actualizado en el sistema.');
        session()->flash('flash.bannerStyle', 'success');

        //return redirect()->route('users');//Finalmente, se redirige al usuario a la ruta 'users'.
        return redirect(request()->header('Referer'));
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user)
    {//Se utiliza el método forceFill() del modelo de usuario para actualizar los campos name, username, email, permiso_id, region_id, status y email_verified_at con los valores proporcionados en el formulario. 
        //El campo email_verified_at se establece en null para indicar que el correo electrónico aún no ha sido verificado.
        $user->forceFill([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'telefono'=>$this->tel,
            'permiso_id' => $this->role,
            'region_id' => $this->region,
            'status' => $this->statId,
            'email_verified_at' => null,
        ])->save();//Luego, se guarda el usuario para aplicar los cambios en la base de datos.

        $user->sendEmailVerificationNotification();//Finalmente, se llama al método sendEmailVerificationNotification() del usuario para enviar una notificación de verificación por correo electrónico al nuevo correo electrónico del usuario.
    }

    public function render()
    {
        $permisos = Permiso::all();//llamamos a todos los permisos
        $zonas = Zona::where('status','Activo')->get();//llamamos a las zonas que esten activas
        $regiones = Region::where('status', 'Activo')->whereNotIn('id', [3,4])->get(); // llamamos a las regiones activas
        $this->deptos = Departamento::select('id', 'name')->orderBy('name', 'asc')->get(); // llamado a los departamentos
        $areas = Areas::where('status', 'Activo')->get(); // Areas
        return view('livewire.usuarios.user-edit', compact('zonas', 'permisos', 'regiones','areas')); // se pasan las variables a la vista
    }
}
