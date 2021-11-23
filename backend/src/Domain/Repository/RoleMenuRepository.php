<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;

class RoleMenuRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getRoleMenuByIdRole($idrole) {
        //return $this->connection->table('menu')->where('idrole', '=', $idrole)->get();
        return $this->connection->table('menus')
                                ->select('menus.*')
                                ->join('rolesmenus', 'menus.idmenu', '=', 'rolesmenus.idmenu')
                                ->where('rolesmenus.idrole', '=', $idrole)
                                ->get();
    }

}