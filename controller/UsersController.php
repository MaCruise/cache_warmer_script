<?php




class UsersController
{


    public static function store($post)
    {
        $user = new User;
        if ($user) {
            $user->username = trim($post['username']);
            $user->email = trim($post['email']);
            $user->password = hash('sha256', trim($post['password']));
            return $user->create();

        }
    }

    public static function edit($id,$post)
    {
        $user = User::find_byId($id);

        if ($user) {
            $user->username = trim($post['username']);
            $user->email = trim($post['email']);
            !empty($_POST['password'])
                ? $user->password = hash('sha256', trim($_POST['password']))
                : null;
            return $user->update();

        }
    }


    public static function delete($id)
    {
        $user = User::find_byId($id);
        return $user->delete();


    }





}