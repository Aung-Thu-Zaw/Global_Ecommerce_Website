<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            "name"=>"Admin",
            "email"=>"admin@gmail.com",
            "password"=>"Password!",
            "role"=>"admin",
            "deleted_at"=>null
        ]);

        User::factory()->create([
            "name"=>"Vendor",
            "email"=>"vendor@gmail.com",
            "password"=>"Password!",
            "role"=>"vendor",
            "deleted_at"=>null
        ]);

        User::factory()->create([
            "name"=>"User",
            "email"=>"user@gmail.com",
            "password"=>"Password!",
            "role"=>"user",
            "deleted_at"=>null
        ]);

        // User::factory(50)->create([
        //     "role"=>"vendor",
        //     "status"=>"active",
        //     "about"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra nulla non tristique laoreet. Nunc convallis sapien et dignissim elementum. In eu faucibus turpis. Phasellus nec ligula vel neque pellentesque ultrices. Aenean vehicula magna a hendrerit scelerisque. Suspendisse sed lacus vulputate eros congue rhoncus. Aenean condimentum, odio nec volutpat volutpat, arcu ante tempus nisi, ut pulvinar ante justo sit amet nibh. Ut quis arcu quis quam mollis rutrum ac quis dui. Aliquam sit amet felis nulla. Duis viverra mi quis urna tincidunt auctor. Vivamus efficitur ligula et magna semper sagittis. In faucibus efficitur massa, id luctus urna pharetra nec.Nullam tincidunt vehicula quam, in venenatis tortor gravida sit amet. Donec consequat nisl et imperdiet lobortis. Aenean hendrerit vel mauris eu sollicitudin. Quisque placerat nisl in ante fringilla auctor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nulla in libero mauris. Nullam a tincidunt libero. Nullam ut nisi ac nunc rhoncus condimentum nec cursus libero. Pellentesque eget urna et quam accumsan faucibus id quis urna. Nam consectetur congue sem, ut venenatis tortor tincidunt ac. Vivamus eu felis ac dui elementum placerat ac eget tortor.

        //         Suspendisse ullamcorper mi risus, et finibus magna blandit quis. Nulla viverra nec lectus at feugiat. Curabitur eget nulla sed lectus efficitur vehicula. Pellentesque vestibulum libero ut lectus euismod commodo. Sed semper feugiat nunc vel condimentum. Donec sodales erat mollis, ullamcorper lorem a, varius neque. Nam et enim ac felis viverra sollicitudin.

        //         Pellentesque at ultricies nunc. Proin facilisis eu velit a faucibus. Donec ac varius ante. In vitae est condimentum, eleifend libero vitae, accumsan quam. Mauris sed lectus quis orci rutrum dapibus sed at dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus aliquet finibus nibh nec fermentum. Integer et nibh ac ante vestibulum euismod et nec nulla. Nullam faucibus vel eros at eleifend. Nullam tristique ante a ex lobortis, quis tristique ligula sodales. Aliquam laoreet laoreet varius. Integer dapibus lacinia mauris at pulvinar. Integer auctor tincidunt turpis at hendrerit.Donec molestie, purus mattis maximus auctor, est tortor fermentum justo, ut accumsan risus nisl non ligula. Nam fermentum, lacus a accumsan ullamcorper, ipsum nisl tristique lorem, a gravida eros purus in eros. Duis porta eget dolor sit amet interdum. Aenean tincidunt turpis aliquam pretium bibendum. Phasellus viverra lacus ligula, auctor ullamcorper neque porttitor vel. Suspendisse condimentum vitae augue eget viverra. Quisque sed dignissim orci, quis ultrices felis. Cras feugiat nibh sed finibus cursus. Sed vel cursus massa. Suspendisse dapibus, purus a commodo tempor, nisi orci commodo sapien, quis iaculis enim neque vitae orci. Praesent et aliquam tellus. Quisque eu sem erat. Pellentesque lacinia elit magna, ac rhoncus sem aliquet sed. Nulla a justo non ligula porta blandit.Nunc pulvinar lobortis nisl, id sagittis lacus elementum quis. Sed id molestie mi, a bibendum justo. Nam enim ante, fringilla eget dictum eget, cursus quis nunc. Donec dapibus accumsan est ornare sodales. Duis vel justo et lacus fermentum rhoncus. Ut eu tellus ullamcorper, viverra est eu, convallis quam. Cras eu tristique neque. In aliquam ornare nibh, in consequat metus dapibus euismod. Cras sit amet est convallis, varius turpis vitae, ultricies tellus. In porta accumsan ligula nec porttitor. Praesent fermentum interdum facilisis. Donec at malesuada mi. Donec porttitor, nunc non elementum ultricies, diam leo sollicitudin magna, eget faucibus est lacus sed dui.

        //         Proin tincidunt nisi ac ligula euismod cursus. Sed eros quam, dictum quis ante at, volutpat pharetra purus. Aliquam dignissim nulla eget turpis tempor, sit amet euismod ante dapibus. Duis vel velit feugiat est ultrices dictum non id purus. Praesent ut nisl ante. Sed ac massa vitae diam scelerisque tincidunt quis ac nisl. Nullam elementum urna mauris, sed elementum justo blandit sit amet. Vivamus sem ipsum, maximus nec consequat non, rhoncus eu tortor. Nunc et turpis eget tellus condimentum maximus. Nulla eu faucibus quam. Nullam turpis tellus, pretium at dignissim eu, placerat a ante. Fusce ut vehicula dolor. Morbi id nulla elementum, commodo nunc et, dignissim odio. Ut sagittis molestie commodo.

        //         Nam ultricies pulvinar purus, nec posuere dui. Proin non auctor orci, in posuere enim. Proin commodo viverra nunc a fringilla. Nam vel gravida enim. Duis eu purus id orci pulvinar pellentesque. Vivamus sagittis felis sit amet fermentum euismod. Donec a ante eget erat gravida interdum vitae vitae libero. Proin vel malesuada nulla. In hac habitasse platea dictumst.",
        // ]);


        // User::factory(50)->create([
        //     "role"=>"vendor",
        //     "status"=>"inactive",
        //     "about"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra nulla non tristique laoreet. Nunc convallis sapien et dignissim elementum. In eu faucibus turpis. Phasellus nec ligula vel neque pellentesque ultrices. Aenean vehicula magna a hendrerit scelerisque. Suspendisse sed lacus vulputate eros congue rhoncus. Aenean condimentum, odio nec volutpat volutpat, arcu ante tempus nisi, ut pulvinar ante justo sit amet nibh. Ut quis arcu quis quam mollis rutrum ac quis dui. Aliquam sit amet felis nulla. Duis viverra mi quis urna tincidunt auctor. Vivamus efficitur ligula et magna semper sagittis. In faucibus efficitur massa, id luctus urna pharetra nec.Nullam tincidunt vehicula quam, in venenatis tortor gravida sit amet. Donec consequat nisl et imperdiet lobortis. Aenean hendrerit vel mauris eu sollicitudin. Quisque placerat nisl in ante fringilla auctor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nulla in libero mauris. Nullam a tincidunt libero. Nullam ut nisi ac nunc rhoncus condimentum nec cursus libero. Pellentesque eget urna et quam accumsan faucibus id quis urna. Nam consectetur congue sem, ut venenatis tortor tincidunt ac. Vivamus eu felis ac dui elementum placerat ac eget tortor.

        //         Suspendisse ullamcorper mi risus, et finibus magna blandit quis. Nulla viverra nec lectus at feugiat. Curabitur eget nulla sed lectus efficitur vehicula. Pellentesque vestibulum libero ut lectus euismod commodo. Sed semper feugiat nunc vel condimentum. Donec sodales erat mollis, ullamcorper lorem a, varius neque. Nam et enim ac felis viverra sollicitudin.

        //         Pellentesque at ultricies nunc. Proin facilisis eu velit a faucibus. Donec ac varius ante. In vitae est condimentum, eleifend libero vitae, accumsan quam. Mauris sed lectus quis orci rutrum dapibus sed at dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus aliquet finibus nibh nec fermentum. Integer et nibh ac ante vestibulum euismod et nec nulla. Nullam faucibus vel eros at eleifend. Nullam tristique ante a ex lobortis, quis tristique ligula sodales. Aliquam laoreet laoreet varius. Integer dapibus lacinia mauris at pulvinar. Integer auctor tincidunt turpis at hendrerit.Donec molestie, purus mattis maximus auctor, est tortor fermentum justo, ut accumsan risus nisl non ligula. Nam fermentum, lacus a accumsan ullamcorper, ipsum nisl tristique lorem, a gravida eros purus in eros. Duis porta eget dolor sit amet interdum. Aenean tincidunt turpis aliquam pretium bibendum. Phasellus viverra lacus ligula, auctor ullamcorper neque porttitor vel. Suspendisse condimentum vitae augue eget viverra. Quisque sed dignissim orci, quis ultrices felis. Cras feugiat nibh sed finibus cursus. Sed vel cursus massa. Suspendisse dapibus, purus a commodo tempor, nisi orci commodo sapien, quis iaculis enim neque vitae orci. Praesent et aliquam tellus. Quisque eu sem erat. Pellentesque lacinia elit magna, ac rhoncus sem aliquet sed. Nulla a justo non ligula porta blandit.Nunc pulvinar lobortis nisl, id sagittis lacus elementum quis. Sed id molestie mi, a bibendum justo. Nam enim ante, fringilla eget dictum eget, cursus quis nunc. Donec dapibus accumsan est ornare sodales. Duis vel justo et lacus fermentum rhoncus. Ut eu tellus ullamcorper, viverra est eu, convallis quam. Cras eu tristique neque. In aliquam ornare nibh, in consequat metus dapibus euismod. Cras sit amet est convallis, varius turpis vitae, ultricies tellus. In porta accumsan ligula nec porttitor. Praesent fermentum interdum facilisis. Donec at malesuada mi. Donec porttitor, nunc non elementum ultricies, diam leo sollicitudin magna, eget faucibus est lacus sed dui.

        //         Proin tincidunt nisi ac ligula euismod cursus. Sed eros quam, dictum quis ante at, volutpat pharetra purus. Aliquam dignissim nulla eget turpis tempor, sit amet euismod ante dapibus. Duis vel velit feugiat est ultrices dictum non id purus. Praesent ut nisl ante. Sed ac massa vitae diam scelerisque tincidunt quis ac nisl. Nullam elementum urna mauris, sed elementum justo blandit sit amet. Vivamus sem ipsum, maximus nec consequat non, rhoncus eu tortor. Nunc et turpis eget tellus condimentum maximus. Nulla eu faucibus quam. Nullam turpis tellus, pretium at dignissim eu, placerat a ante. Fusce ut vehicula dolor. Morbi id nulla elementum, commodo nunc et, dignissim odio. Ut sagittis molestie commodo.

        //         Nam ultricies pulvinar purus, nec posuere dui. Proin non auctor orci, in posuere enim. Proin commodo viverra nunc a fringilla. Nam vel gravida enim. Duis eu purus id orci pulvinar pellentesque. Vivamus sagittis felis sit amet fermentum euismod. Donec a ante eget erat gravida interdum vitae vitae libero. Proin vel malesuada nulla. In hac habitasse platea dictumst.",
        // ]);


        // User::factory(50)->create(["shop_name"=>null,"company_name"=>null,"role"=>"user"]);

        // User::factory(100)->create(["status"=>"active","role"=>"user","created_at"=>now()]);

    }
}
