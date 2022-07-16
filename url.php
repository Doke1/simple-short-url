<?php
    require "./config.php";

    class Url {
        private String $defaultUri;
        private String $page;
        private $uriPath;
        function __construct(String $uri = "")
        {
            $this->defaultUri = DEFAULT_URI;
            # "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}"
            $this->page = $uri;
            $this->uriPath = json_decode(file_get_contents("./uri.json"), true);
        }
        function shortUri() {
            $abc = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ1234567890";
            for($i = 0;$i < 10; $i++) {
                $this->defaultUri .= $abc[rand(0, 10)];
            }
            echo $this->defaultUri;
            $this->saveUri($this->defaultUri);
        }
        function saveUri(String $uri) {
            $this->uriPath[] = array(
                "id" => sizeof($this->uriPath)+1,
                "shortURI" => $uri,
                "uri" => $this->page,
            );
            file_put_contents("./uri.json", json_encode($this->uriPath));
        }
        function getUri() {
            $path = $this->uriPath;
            $accUri = "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}";
            print_r($_SERVER);
            for($i = 0; $i < sizeof($path); $i++) {
                if($path[$i]["shortURI"] === $accUri) {
                   $this->redirectUri($path[$i]["uri"]);
                }
            }
        }
        function redirectUri(String $uri) {
            header("HTTP/1.0 301 Moved Permanently");
            header("Location: {$uri}");
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents("php://input"), true);

        $uri = new Url($data["location"]);
        $uri->shortUri();
    }
    if(!empty($_SERVER["QUERY_STRING"])) {
        $uri = new Url();
        $uri->getUri();
    }
?>
