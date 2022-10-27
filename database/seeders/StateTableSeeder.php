<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('state')->insert([
            ["id"=>"11", "name"=>"Rondônia","abreviation"=>"RO","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"12", "name"=>"Acre","abreviation"=>"AC","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"13", "name"=>"Amazonas","abreviation"=>"AM","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"14", "name"=>"Roraima","abreviation"=>"RR","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"15", "name"=>"Pará","abreviation"=>"PA","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"16", "name"=>"Amapá","abreviation"=>"AP","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"17", "name"=>"Tocantins","abreviation"=>"TO","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"21", "name"=>"Maranhão","abreviation"=>"MA","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"22", "name"=>"Piauí","abreviation"=>"PI","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"23", "name"=>"Ceará","abreviation"=>"CE","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"24", "name"=>"Rio Grande do Norte","abreviation"=>"RN","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"25", "name"=>"Paraíba","abreviation"=>"PB","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"26", "name"=>"Pernambuco","abreviation"=>"PE","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"27", "name"=>"Alagoas","abreviation"=>"AL","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"28", "name"=>"Sergipe","abreviation"=>"SE","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"29", "name"=>"Bahia","abreviation"=>"BA","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"31", "name"=>"Minas Gerais","abreviation"=>"MG","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"32", "name"=>"Espírito Santo","abreviation"=>"ES","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"33", "name"=>"Rio de Janeiro","abreviation"=>"RJ","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"35", "name"=>"São Paulo","abreviation"=>"SP","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"41", "name"=>"Paraná","abreviation"=>"PR","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"42", "name"=>"Santa Catarina","abreviation"=>"SC","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"43", "name"=>"Rio Grande do Sul","abreviation"=>"RS","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"50", "name"=>"Mato Grosso do Sul","abreviation"=>"MS","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"51", "name"=>"Mato Grosso","abreviation"=>"MT","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"52", "name"=>"Goiás","abreviation"=>"GO","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
            ["id"=>"53", "name"=>"Distrito Federal","abreviation"=>"DF","status"=>"1","created_at"=>date("Y-m-d H:i:s")],
        ]);
    }
}
