<?php


/**
 * Plugin name: Rest Api 
 * Description: This is my rest api plugin
 * Url: http://rest.php.net/
 * Author: Muslim khan
 */

class ra_rest_api {
    public function __construct() {
          add_action('rest_api_init', array($this, 'register_toutes'));
    }

    public function register_toutes()  {
        register_rest_route( 'rest-api/v1/', '/hello',[   // rest-api holo namespace and hello route
            'method' => 'GET',
            'callback' => [$this, 'say_hello']
        ]);



        // amra jodi sob post gulo dekhte chai tahole ai code gulo use kort pari 
        register_rest_route( 'rest-api/v1/', '/posts',[   // rest-api holo namespace and hello route
        'method' => 'GET',
        'callback' => [$this, 'get_posts']
        ]);


        // arekta kaj kora jai seta holo post ar id ta ber korar jonno ai code ta use korte hbe 
        register_rest_route( 'rest-api/v1/', '/posts/(?P<id>\d+)',[   // d+ ta holo data type rest-api holo namespace and posts route
            'method' => 'GET',
            'callback' => [$this, 'get_post']
        ]);


        // ki vabe query string access kora jai seta dekhano holo 
        register_rest_route( 'rest-api/v1/', '/qs',[   // d+ ta holo data type rest-api holo namespace and posts route
            'method' => 'GET',
            'callback' => [$this, 'get_qurey']
        ]);
    }

    // query string access control and joto mon chai parameter pathano jbe 
    public function get_qurey($request) {
        $request_query = $request ->get_params();
        // $page_number = $request ->get_param('page');     // akta kotha mone rakhte hbe seta holo onek 1 ta parameter nite chaile get_perams nite hbe .. r onek gulo nite chaile get_perams nite hbe 
        // if( $page_number ) {
        //     $page_number = 1;
        return new WP_REST_Response($request_query);
        
    }

    // find all post id and all post showing
    public function get_post($data) {
        $post_id = $data['id'];
        $post = get_post($post_id);

        if ( ! $post ) {
            return new WP_Error('error_post', 'No post found', ['status' => 404]);
        }
        return new WP_REST_Response($post);
    }


    // post showing functionality
    public function get_posts() {
        $posts = get_posts([
            'post_type' => 'post',
            'post_par_page' =>-1,
            'status' => 'published'
        ]);

        return new WP_REST_Response($posts);
    }


  
    

    public function say_hello() {
        // return 'hello rest api';

        $response = [
            'message' => 'hello rest api',
        ];

        return new WP_REST_Response($response);
    }
}
new ra_rest_api();