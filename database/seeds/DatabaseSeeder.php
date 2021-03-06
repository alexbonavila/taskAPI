<?php

use App\Tag;
use App\Task;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $faker =Faker\Factory::create();

        // $this->call(UserTableSeeder::class);

        $this->seedTasks($faker);
        $this->seedTags($faker);

        Model::reguard($faker);
    }

    private function seedTasks($faker)
    {
        foreach(range(0,100)as $number){
            $task = new Task();

            $task->name=$faker->sentence;
            $task->done=$faker->boolean;
            $task->priority=$faker->randomDigit;
            $task->save();
        }
    }

    private function seedTags($faker)
    {
        foreach(range(0,100)as $number){
            $tag = new Tag();

            $tag->name=$faker->word;
            $tag->save();
        }
    }
}
