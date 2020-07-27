<?php


class WordpressAPI
{
    private $user;
    private $password;
    private $apiRootURL;

    public function __construct($apiRoot, $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->apiRoot = $apiRoot;
    }

    public function searchCategory($search)
    {
        return json_decode(file_get_contents($this->apiRoot . '/categories/?search='.urlencode($search)));
    }

    public function searchMedia($search)
    {
        return json_decode(file_get_contents($this->apiRoot . '/media/?search='.urlencode($search)));
    }

    public function searchPost($search)
    {
        return json_decode(file_get_contents($this->apiRoot . '/posts/?search='.urlencode($search)));
    }


    public function updatePostCategories($postId, $categories)
    {
        $data = http_build_query(['categories' => $categories]);
        $url = $this->apiRoot . '/posts/'.$postId;
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Content-Disposition: form-data;',
            'Authorization: Basic ' . base64_encode( $this->user . ':' . $this->password ),
        ] );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($result);
    }

    public function createPost($title, $content = '', $featured_media = null)
    {

        $data = 'title=' . urlencode($title) . '&content=' . urlencode($content) . '&status=publish';
        if($featured_media) {
            $data .= '&featured_media=' . urlencode($featured_media);
        }

        $url = $this->apiRoot . '/posts/';
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Content-Disposition: form-data;',
            'Authorization: Basic ' . base64_encode( $this->user . ':' . $this->password ),
        ] );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($result);
    }


    public function createTag($name, $description = '', $slug = null)
    {

        $data = 'name=' . urlencode($name) . '&description=' . urlencode($description);
        if($slug) {
            $data .= '&slug=' . urlencode($slug);
        }

        $url = $this->apiRoot . '/tags/';
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Content-Disposition: form-data;',
            'Authorization: Basic ' . base64_encode( $this->user . ':' . $this->password ),
        ] );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($result);
    }


    public function createCategory($name, $description = '', $slug = null)
    {
        $data = 'name=' . urlencode($name) . '&description=' . urlencode($description);
        if($slug) {
            $data .= '&slug=' . urlencode($slug);
        }
        $url = $this->apiRoot . '/categories/';
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Content-Disposition: form-data;',
            'Authorization: Basic ' . base64_encode( $this->user . ':' . $this->password ),
        ] );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($result);
    }



    public function uploadImage($source, $destinationName)
    {
        $file = file_get_contents( $source );

        $url = $this->apiRoot . '/media/';
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $file );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Content-Disposition: form-data; filename="' . $destinationName . '"',
            'Authorization: Basic ' . base64_encode( $this->user . ':' . $this->password ),
        ] );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json_decode($result);
        
    }

    public function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}