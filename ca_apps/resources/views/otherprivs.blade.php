
    @php
        $affbtnexp='non';
        $usersprivileges = Session::get('userprivilege_list');

        // dd($usersprivileges);
        if (in_array(25, $usersprivileges)) {
            // code...
             $affbtnexp ='oui';
        }
    @endphp