<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReview>
 */
class ProductReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "product_id"=>fake()->numberBetween(1, 250),
            "vendor_id"=>fake()->numberBetween(1, 61),
            "user_id"=>fake()->numberBetween(1, 263),
            "review_text"=>"<p>Aut occaecati sint incidunt dolorem repellat. Modi doloribus mollitia adipisci vel atque itaque. Veritatis voluptas voluptatem fuga in cumque cupiditate sequi. Ullam consequatur autem ducimus mollitia earum corrupti tempora ab. Nihil quis sint sit maxime amet omnis. Excepturi ratione accusantium et eos debitis quod. Ipsum quo ut molestias aspernatur quod officiis id. Eos in explicabo omnis. Quidem illum quos possimus sunt qui eos praesentium. Molestiae est dolores ipsum dolores. Sunt exercitationem dolor reprehenderit labore. Id eum asperiores dolor est ut id. In aspernatur quaerat laboriosam rem explicabo delectus rerum. Quam consequatur suscipit magnam commodi ex. Numquam repudiandae non autem impedit eius. Dolor porro facilis et vitae illum nobis aut.</p><p>&nbsp;</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque sagittis volutpat risus gravida volutpat. Aliquam tempus justo vel lectus iaculis, a scelerisque augue imperdiet. Vestibulum porta tortor et vestibulum consequat. Ut orci risus, aliquam vel sodales sed, luctus eu quam. Ut malesuada massa a quam imperdiet interdum. Pellentesque ut risus sit amet massa rutrum ullamcorper sed tristique ligula. Vestibulum ut nulla convallis, egestas sem eu, porttitor dolor. Suspendisse aliquam sagittis magna eu euismod. Quisque lobortis mi nec pellentesque faucibus. Nullam pretium, neque at scelerisque vehicula, quam magna consectetur libero, quis elementum est dolor et ipsum. Duis a mauris id orci auctor tincidunt. Phasellus dapibus purus vitae ante tincidunt, eu porttitor mi sagittis. Mauris luctus, ante vel lobortis sodales, elit nulla lobortis eros, non suscipit velit quam sed dui. In mattis efficitur elementum. Pellentesque placerat purus nec convallis posuere. Vivamus imperdiet nec metus ut egestas.</p><p>&nbsp;</p><p>Maecenas orci massa, mollis nec augue a, euismod lobortis eros. Praesent ultrices magna id massa sagittis sagittis. Aliquam fringilla turpis quis urna consectetur scelerisque. Aenean quis diam sit amet risus commodo hendrerit. Quisque dolor diam, dictum a rhoncus a, malesuada at enim. Cras id lorem urna. Phasellus luctus arcu a odio viverra, sit amet suscipit tortor lacinia. Aliquam eget urna dapibus, efficitur mi id, consequat magna. Aenean nec pretium ex. Vivamus eu viverra tellus. Nam lobortis tortor nec sem interdum, sit amet convallis purus accumsan. Vivamus pulvinar aliquet pharetra. Maecenas vel augue semper arcu lacinia dignissim ut eu sapien. Integer at massa malesuada, volutpat diam ut, rutrum turpis.</p><p>&nbsp;</p><p>Nunc tincidunt eros et nisl imperdiet posuere. Integer turpis justo, scelerisque ut nisl eu, cursus gravida lacus. Sed fermentum nisi ullamcorper nunc accumsan, eget rhoncus velit faucibus. Integer egestas turpis mauris, ac lacinia justo imperdiet sit amet. Suspendisse eget rutrum ligula. Proin justo massa, rhoncus eget purus quis, maximus tempor dolor. Maecenas nec interdum est, ac varius diam. Aenean ut lacus a lectus mollis accumsan. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent posuere, ligula vel dignissim laoreet, quam dui luctus orci, ac commodo nunc nisl sed sapien. Nunc sed diam et eros egestas cursus eu eu nisi. Aenean laoreet lectus ut quam vulputate porta. Sed dictum justo nec ultricies dapibus. Etiam tempus quam vel turpis imperdiet interdum. In fringilla lobortis arcu vitae feugiat. Sed at purus et ante fringilla congue a eu mauris.</p><p>&nbsp;</p><p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Curabitur finibus imperdiet erat non congue. Cras pulvinar arcu sit amet magna elementum ultrices. Quisque tempor massa sed tortor commodo porta. Nullam ut blandit lectus. Praesent quis fermentum risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean ultrices arcu velit, et venenatis dolor fermentum sit amet. Phasellus euismod finibus scelerisque. Vestibulum vestibulum erat tortor. Quisque nec nunc non purus sodales consequat. Integer interdum vehicula placerat. Nunc eget semper augue.</p><p>&nbsp;</p><p>Sed convallis ex ut purus fringilla, a ornare tellus ullamcorper. Pellentesque imperdiet sem vitae rhoncus ultrices. In dapibus id massa a dignissim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec blandit dui at sem feugiat egestas quis non lorem. Nam ullamcorper eros non ex sodales rhoncus. Pellentesque quis orci non orci condimentum vulputate eget quis tellus. Aliquam varius est a tincidunt posuere. Quisque sed sem at nisi tristique egestas id a ex. Nunc feugiat lacus et justo malesuada gravida. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque placerat nulla id nunc ultricies pellentesque.</p>",
            "rating"=>fake()->numberBetween(1, 5),
            "status"=>fake()->randomElement([true,false])
        ];
    }
}
