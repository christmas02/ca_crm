
    <?php
        $affbtnexp='non';
        $usersprivileges = Session::get('userprivilege_list');

        // dd($usersprivileges);
        if (in_array(25, $usersprivileges)) {
            // code...
             $affbtnexp ='oui';
        }
    ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/otherprivs.blade.php ENDPATH**/ ?>