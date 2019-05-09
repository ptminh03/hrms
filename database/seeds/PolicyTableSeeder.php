<?php

use Illuminate\Database\Seeder;
use App\Models\Policy;

class PolicyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Policy)->insert([
            [
                'employee_id' => rand(1, 10),
                'title' => 'Security Policy',
                'content' => '<p>People in IT often think of security as in software&#39;s security, however this policy covers more than that. It will talk about how every employee must do to ensure security for our workplace, our physical and digital assets, our clients&#39; reputation and confidence.</p>

                <p>Please download the file at the bottom of this page.</p>
                '
            ],
            [
                'employee_id' => rand(1, 10),
                'title' => 'Communication Policy',
                'content' => '<p>This policy details how an employee should communicate to everyone else in the company or to external entities. Its main role is to maximise the consistency and accuracy of information being passed around the companies, the projects and team members.</p>
                '
            ],
            [
                'employee_id' => rand(1, 10),
                'title' => 'Paid Leave Postponement Memo',
                'content' => '<p>This memo aims to respond to requests from Team Managers/ Project Managers about the postponement of using paid leave for some specific employees. Applicable employees are those who continuously worked in a high load project that they are unable to take any day-off in entire the duration.</p>
                '
            ],
            [
                'employee_id' => rand(1, 10),
                'title' => 'Welcome Lunch to Newcomer Memo',
                'content' => '<p>This officially announces the new policy regarding budget allocation policy to be spent for welcoming newcomer. The newcomer is someone who joins Asian Tech to work or attend an internship program (pre-employment).</p>
                '
            ]
        ]);
    }
}
