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
                'target_id' => rand(1, 100),
                'type' => 1,
                'title' => 'I went to the concert last night with my friends',
                'content' => '<p>Dear all,</p>

                <p>Thank you very much for your letter which arrived a few days ago. It was lovely to hear from you. I am sorry, I haven&rsquo;t written for you such along time because I studied hard to pass the final exam. However, I had agreat weekend more than every when I went to live concerts last night with my friends. Now, I am writing to tell you how the wonderful concert is.</p>
                
                <p>It is the beautiful concert I have ever taken part in with many people and the miracle of sound of piano. As you know, my pianist is Yiruma and in last concert I couldn&rsquo;t believe that he appeared in my eyes and gave me a big hug after his performance. I also listen a soothing music which is played by him and other professional musicians. Only when I heard his song from the stage I feel anythings around me seem to disappear and I can fly with many stars on the sky to forget all my fears which I suffered before.</p>
                
                <p>That is amazing.</p>
                
                <p>Let&rsquo;s come back to my live concert. It is so cool and until now I can&rsquo;t forget my feeling about it. Do you often to go live concerts? What kind of music do you like listening to? Who is your favourite singer?</p>
                
                <p><em>I am glad if you tell me about it in the next letter</em></p>
                
                <p><em>I look forward to your reply</em></p>
                
                <p><em>Your sincerely</em></p>
                '
            ],
            [
                'target_id' => rand(1, 100),
                'type' => 1,
                'title' => 'We had dinner at a new restaurant yesterday',
                'content' => '<p>Dear all,</p>

                <p>Thank you very much for your letter which arrived a few days ago. It was lovely to hear from you.</p>
                
                <p>I think the restaurant which you told me in the letter is very interesting. I also like to eat out and I usually go to a restaurant for dinner with my family tiwce a month. Our favourite restaurant is a traditional restaurant in Hang Bong street. It is not big but it is always busy. There are only afew tables in the restaurant and on each table is a vase with lovely flowers. There are plants in the room corners. I usually order the traditional dishes and eat them with rice. For example, fish cooked with sauce, spring roll,&hellip;and vegetable and so on. The food is deliciuous so we enjoy it very much. The service is also quick and frienfdly . My family always have pleasant evening at our favourite restaurant.</p>
                
                <p><em>Shall we go there when you come to visit my family next time?</em></p>
                
                <p><em>See you next time.</em></p>
                
                <p><em>Minh</em></p>
                '
            ],
            [
                'target_id' => rand(1, 100),
                'type' => 1,
                'title' => 'Tell me about a teacher from your past',
                'content' => '<p>Thank you for our class&rsquo; photo you sent me afew days ago. I was so glad to write for you and tell you about my feeling after I receive it.</p>

                <p>That photograph made me remember my old teacher who taught us high school. She is slim with along hair and blue eyes. Do you remember her? Our enghlish teacher, her name is Sara. I can&rsquo;t forget that days when she played game with us in each class and we sang &lsquo; Anilmal song&rsquo; together. I also remember that She was very sad when our class didn&rsquo;t do homework and we felt so guilty with her. Then we studied Enghlish hard to fix our mistakes and she was so happy. But now she doesn&rsquo;t still teach Enghlish in Viet Nam. Ha - our classmates said she came back England with her husband. I hope she would come to Viet nam, I will meet her because I miss her so much. What about you? What do you think about her? Have you ever had the old teacher who made you unforgettable?</p>
                
                <p><em>Please tell me in next letter. I look forward to your reply.</em></p>
                
                <p><em>Minh.</em></p>
                '
            ],
            [
                'target_id' => rand(1, 100),
                'type' => 1,
                'title' => 'You went to a party last week, didn\'t you? Did you have a good time there? Tell me about that party',
                'content' => '<p>Dear all,</p>

                <p>How are you? I hear that you are going to travel with your family next week . I wish you will have a good time. Last weekend I went to the party arranged to congratulate Lan. She won competition in her office. That night we had a good time. The party was arranged at Lan&#39;s house. Her mother and sister helped to us to prepare interesting dinner. We want to make her surprised. There were many people to join this party and maybe you know some of them. After good meal, we talked and listened romantic songs and danced together. We had interesting and unforgetable night with friends. Ahh, Are you going to next Friday? Don&#39;t forget to send me some postcards from places where you will come.</p>
                
                <p><em>Goodbye and see you after you com back.</em></p>
                '
            ],
            [
                'target_id' => rand(1, 100),
                'type' => 1,
                'title' => 'Can you describle the weather in your country? What\'s the weather like at the monent? What outdoor activities are you able to do at this time of year?',
                'content' => '<p>Dear all,</p>

                <p>It is so wet here. I am writing to tell you about the weather in my country. In my country, it is in spring with high humidity. My country is a tropical monsoon climate. Broadly speaking, the weather in Viet Nam is dicated by two monsoon seasons the southwest monsoon from April to September and the northeast monsoon from October t late March or early April. Moreover the northeast monsoon effects bring lower temperatures to my city, Ha noi and all days in Ha noi is in rain. In fact, I am fed up with rainy day because I can&#39;t go out to shopping with my friend. Only thing I can do in these days is writing letter for you and tell you about the terrible weather here. All my clothes can&#39;t be dry and the way I go to school every day is daubed with mud</p>
                
                <p><em>Lovely</em></p>
                
                <p><em>Join</em></p>
                '
            ],
            [
                'target_id' => rand(1, 100),
                'type' => 1,
                'title' => 'I\'m glad you like your job. Tell me about',
                'content' => '<p>Dear all,</p>

                <p>How are you? Thanks for your letter. I am so happy because you always miss and think of me. Now, I am working as a teacher in the milytary academy logistics . I start my working day at 7 pm every morning and finish it at 5 pm. You know I love this job, right? It has been my dream to become a good teacher for such a long time. I like my job because I can use my ability and knowledge to finish my work the best. Morever, I can study valuable experience from colleagues not only about work but also about life. Now every day is wonderful day with me. And you, your job is very interesting, isn&#39;t it? Let you tell me about it in the next letter</p>
                
                <p>I look forward to hearing from you</p>
                
                <p><em>Love</em></p>
                
                <p><em>Mai</em></p>
                '
            ],
            [
                'target_id' => rand(1, 100),
                'type' => 1,
                'title' => 'Could you give me some advice? I\'m going to spend my next summer holiday in your country? Where should I go? What should I see?',
                'content' => '<p>Dear all,</p>

                <p>How are you? I hope you are fine. I have received your letter asking for my advice for your next summer holiday in Viet Nam. I am glad to give you some. As you are living in temperature climate It&#39;s a great ideal to have a holiday in tropical country like Viet Nam. You can experience sunny and windy days here. So, why do you go to Nha trang beach? It is one of our most beautiful beachs and is in recognition of the world as the most attactive destination in Viet Nam. I am sure you enjoy bathing in the sunshine and swimming in freshwater and surfing. If you like, I can help you book a tour for you to know mre about other interesting places in Nha trang such as temples, pogodas,...Nha trang is also famous for saefood. Therefore, It is a paradise of food for you to enjoy. I think this place is good one for you to relax and enjoy yourself and get rid of worries as well as stress.<br />
                Let me know your decision. I hope to see you in Viet Nam as soon as possible</p>
                
                <p><em>Love</em></p>
                
                <p><em>Mai</em></p>
                '
            ],
        ]);
    }
}
