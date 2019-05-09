<?php

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new News)->insert([
            [
                'target_id' => rand(1, 3),
                'type' => 1,
                'title' => 'Quarterly Award Celebration on next MCM, Apr 22nd 2019',
                'content' => '<p>Good Morning, ATers!&nbsp;<br />
                <br />
                Important note&nbsp;for our next MCM with Q1&#39;19 Awarding Celebration. Please ensure to show up at 8AM and cheer up for the award winner selected by each team.<br />
                Before that, BO Rep will remind you all about the update policy for AT Language Incentive program, and AT Professional Certification&nbsp;Bonus.&nbsp;<br />
                <br />
                See you all there!<br />
                <br />
                Best Regards,<br />
                Toan Nguyen T.</p>
                '
            ],
            [
                'target_id' => rand(1, 3),
                'type' => 1,
                'title' => 'AT-Portal version 1.7.1-beta released',
                'content' => '<h2>AT-Portal version 1.7.1-beta released</h2>

                <p>Good day our precious users!<br />
                Hope you enjoyed the holiday.<br />
                On behalf of AT-Portal team, I would like to inform that AT-Portal had a big jump from v1.6.6 to&nbsp;<a href="https://github.com/AsianTechInc/AT-Portal/wiki/Releases-Notes-v1.7.1-beta">v1.7.1</a>&nbsp;after a hard-working month.<br />
                Here are the most outstanding updates:</p>
                
                <ul>
                    <li>Syncing AT-Portal data with Cloud Storage (Amazon S3).</li>
                    <li>Introducing a new feature that helps TMs &amp; PMO to check resources assignment for each team.</li>
                    <li>Combining lockers and devices which are assigned to each staff that allows SA team to audit the Device Tracking process by an easy &amp; effective way.</li>
                </ul>
                
                <p>Stay tuned for a big surprise feature coming up next at our end of April release.<br />
                Vi Nguyen</p>
                '
            ]
        ]);
    }
}
