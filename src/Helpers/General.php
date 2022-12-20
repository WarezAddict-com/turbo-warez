<?php

/** Namespace **/
namespace Turbo\Helpers;

/** General **/
class General
{
    // Clean POST Data
    public static function cleanData($data)
    {
        $clean = filter_var($data, FILTER_SANITIZE_STRING);
        return $clean;
    }

    public static function sanitize($text)
    {

        // Transliterate the text/string to US ASCII
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // Lowercase text/string
        $text = strtolower($text);

        // Only allow a to z and/or 0 to 9
        $text = preg_replace('/([^a-zA-Z 0-9]+)/', '', $text);

        // Trim whitespace
        $text = trim($text);

        // Return cleaned text/string
        return $text;
    }

    /**
     * Timestamp
     *
     * Current Universal Time in the specified format.
     *
     * @static
     * @param  string $format format of the timestamp
     * @return string $timestamp formatted timestamp
     */
    public static function timestamp($format = 'Y-m-d H:i:s')
    {
        return gmdate($format);
    }

    /**
     * Truncate a string to a specified length without cutting a word off.
     *
     * @param   string  $string  The string to truncate
     * @param   integer $length  The length to truncate the string to
     * @param   string  $append  Text to append to the string IF it gets
     *                           truncated, defaults to '...'
     * @return  string
     */
    public static function safe_truncate($string, $length, $append = '...')
    {
        $ret        = substr($string, 0, $length);
        $last_space = strrpos($ret, ' ');

        if ($last_space !== false && $string != $ret) {
            $ret     = substr($ret, 0, $last_space);
        }

        if ($ret != $string) {
            $ret .= $append;
        }

        return $ret;
    }

    /**
     * Truncate the string to given length of characters.
     *
     * @param string  $string The variable to truncate
     * @param integer $limit  The length to truncate the string to
     * @param string  $append Text to append to the string IF it gets
     *                        truncated, defaults to '...'
     * @return string
     */
    public static function limit_characters($string, $limit = 100, $append = '...')
    {
        if (mb_strlen($string) <= $limit) {
            return $string;
        }

        return rtrim(mb_substr($string, 0, $limit, 'UTF-8')) . $append;
    }

    /**
     * Truncate the string to given length of words.
     *
     * @param $string
     * @param $limit
     * @param string $append
     * @return string
     */
    public static function limit_words($string, $limit = 100, $append = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $limit . '}/u', $string, $matches);

        if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
            return $string;
        }

        return rtrim($matches[0]).$append;
    }

    public static function onlyNum($input)
    {
        $inputA = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        $inputB = preg_replace('/(-)/', '', $inputA);
        $inputC = preg_replace('/[^1-9]/', '', $inputB);
        if (is_numeric($inputC)) {
            return (int)$inputC;
        }
        // NOT Numeric
        return false;
    }

    public static function makeSlug($string = '')
    {
        $string = iconv('utf-8', "us-ascii//TRANSLIT", $string);
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }

    /**
     * Is Empty
     *
     * Checks if a string is empty. PHP's empty() returns true for a string
     * of "0"... and also doesn't apply trim() to the value to ensure it's
     * not just a bunch of spaces!
     *
     * @static
     * @param  string $value string(s) to be checked
     * @return boolean whether or not the string is empty
     */
    public static function isEmpty()
    {
        foreach (func_get_args() as $value) {
            if (trim($value) == '') {
                return true;
            }
        }

        return false;
    }

    // Pretty JSON
    public static function prettyJson($data)
    {
        /** json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); **/
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    }

    /**
     * Convert Timestamp
     *
     * @param  string $dateTime Epoch Timestamp from time()
     * @return string           Pretty Timestamp!
     *
     */
    public static function convertTimestamp($dateTime)
    {
        $newTimestamp = date('m-d-Y g:i:s A', $dateTime);
        return $newTimestamp;
    }

    private function getCsv($dir)
    {
        if (!isset($dir)) {
            $dir = dirname(__DIR__, 2) . '/data/';
        }

        $files = [];
        $dh = opendir($dir);
        if ($dh === false) {
            //throw new InvalidArgumentException('Could not open directory');
            return false;
        }
        while (($file = readdir($dh)) !== false) {
            //if ($file == '.' or $file == '..' or substr($file, -4) !== '.csv') {
            if (substr($file, -4) !== '.csv') {
                continue;
            }
            $files[] = $file;
        }
        closedir($dh);
        return $files;
    }

    /**
     * Does string start with a substring?
     *
     * @param string $haystack Given string
     * @param string $needle   String to search at the beginning of $haystack
     * @param bool   $case     Case sensitive
     *
     * @return bool True if $haystack starts with $needle.
     *
     */
    public static function startsWith($haystack, $needle, $case = true)
    {
        if ($case) {
            return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
        }
        return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
    }

    /**
     * Tells if a string ends with a substring
     *
     * @param string $haystack Given string.
     * @param string $needle   String to search at the end of $haystack.
     * @param bool   $case     Case sensitive.
     *
     * @return bool True if $haystack ends with $needle.
     *
     */
    public static function endsWith($haystack, $needle, $case = true)
    {
        if ($case) {
            return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
        }
        return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
    }

    /**
     * htmlspecialchars() wrapper, supports multidimensional array of strings
     *
     * @param mixed $input Data to escape: single string or rray of strings
     *
     * @return string escaped
     *
     */
    public static function escape($input)
    {
        if (is_bool($input)) {
            return $input;
        }

        if (is_array($input)) {
            $out = array();
            foreach ($input as $key => $value) {
                $out[$key] = escape($value);
            }
            return $out;
        }
        return htmlspecialchars($input, ENT_COMPAT, 'UTF-8', false);
    }

    /**
     * Unescape stuff
     *
     * @param string $str the string to unescape
     *
     * @return string unescaped string
     *
     */
    public static function unescape($str)
    {
        return htmlspecialchars_decode($str);
    }

    /**
     * Generates API Key
     *
     * Note: methods used here are predictable and NOT secure
     * or suitable for crypto!
     *
     * USE WITH CAUTION! YOU HAVE BEEN WARNED!
     *
     * PHP 7 provides random_int(), designed for crypto, bro
     *
     * @param string $username Username
     * @param string $salt     Password hash salt
     *
     * @return string|bool Generated API secret, 12 char length
     *
     */
    public static function generate_api_secret($username, $salt)
    {
        if (empty($username) || empty($salt)) {
            return false;
        }

        return str_shuffle(substr(hash_hmac('sha512', uniqid($salt), $username), 10, 12));
    }

    /**
     * Replaces multi whitespaces with a single space
     *
     * @param string $string Input string
     *
     * @return mixed Normalized string
     *
     */
    public static function normalize_spaces($string)
    {
        return preg_replace('/\s{2,}/', ' ', trim($string));
    }

    /**
     * Check if input is integer, no matter its real type
     *
     * PHP is shitty at this...
     * is_int() - returns false if input is a string
     * ctype_digit() - returns false if input is integer OR negative
     *
     * @param mixed $input value
     *
     * @return bool true if the input is an integer, false otherwise
     *
     */
    public static function is_integer_mixed($input)
    {
        if (is_array($input) || is_bool($input) || is_object($input)) {
            return false;
        }
        $input = strval($input);
        return ctype_digit($input) || (self::startsWith($input, '-') && ctype_digit(substr($input, 1)));
    }

    /**
     * Convert 16 Megabytes (16M) to bytes
     *
     * @param string $val Size expressed in string
     *
     * @return int Size expressed in bytes
     *
     */
    public static function return_bytes($val)
    {
        if (self::is_integer_mixed($val) || $val === '0' || empty($val)) {
            return $val;
        }
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = intval(substr($val, 0, -1));
        switch ($last) {
            case 'g':
                $val *= 1024;
                break;
            case 'm':
                $val *= 1024;
                break;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }

    /**
     * Convert ugly bytes to pretty, human readable size
     *
     * @param int $bytes value
     *
     * @return string Human readable size
     *
     */
    public static function human_bytes($bytes)
    {
        if ($bytes === '') {
            return t('Setting not set');
        }
        if (! self::is_integer_mixed($bytes)) {
            return $bytes;
        }
        $bytes = intval($bytes);
        if ($bytes === 0) {
            return t('Unlimited');
        }

        $units = [t('B'), t('kiB'), t('MiB'), t('GiB')];
        for ($i = 0; $i < count($units) && $bytes >= 1024; ++$i) {
            $bytes /= 1024;
        }

        return round($bytes) . $units[$i];
    }

    public function sourceCode($url)
    {
        $lines = file($url);

        foreach ($lines as $line_num => $line) {
            echo "<p>" . htmlspecialchars($line) . "</p>";
        }
    }

    public function nonAscii($output)
    {
        $output = preg_replace('/[^(x20-x7F)]*/','', $output);
        return $output;
    }

    public function gravatar($email, $size = 64)
    {
        // Validate Email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $url = "https://www.gravatar.com/avatar/" . md5($email) . "?d=mp&r=x";
        }

        if (filter_var($size, FILTER_VALIDATE_INT) && $size != 64) {
            $url .= "&s=" . $size;
        } else {
            $url .= "&s=64";
        }

        $code = '<img class="img-fluid" src="' . $url . '" alt="Gravatar">';

        return $code;
    }

    public function paginate($item_per_page, $current_page, $total_records, $total_pages, $page_url)
    {
        /** https://www.sanwebe.com/2011/05/php-pagination-function **/

        $pagination = '';

        if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
            $pagination .= '<ul class="pagination">';
            $right_links = $current_page + 3;
            $previous = $current_page - 3;
            $next = $current_page + 1;
            $first_link = true;

            if ($current_page > 1) {
                $previous_link = ($previous==0) ? 1: $previous;
                $pagination .= '<li class="first"><a href="'.$page_url.'?page=1" title="First">«</a></li>';
                $pagination .= '<li><a href="'.$page_url.'?page='.$previous_link.'" title="Previous"><</a></li>';

                for ($i = ($current_page-2); $i < $current_page; $i++) {
                    if ($i > 0) {
                        $pagination .= '<li><a href="'.$page_url.'?page='.$i.'">'.$i.'</a></li>';
                    }
                }

                $first_link = false;
            }

            if ($first_link) {
                $pagination .= '<li class="first active">'.$current_page.'</li>';
            } elseif ($current_page == $total_pages) {
                $pagination .= '<li class="last active">'.$current_page.'</li>';
            } else {
                $pagination .= '<li class="active">'.$current_page.'</li>';
            }

            for ($i = $current_page + 1; $i < $right_links; $i++) {
                if ($i <= $total_pages) {
                    $pagination .= '<li><a href="'.$page_url.'?page='.$i.'">'.$i.'</a></li>';
                }
            }

            if ($current_page < $total_pages) {
                $next_link = ($i > $total_pages)? $total_pages: $i;
                $pagination .= '<li><a href="'.$page_url.'?page='.$next_link.'" >></a></li>';
                $pagination .= '<li class="last"><a href="'.$page_url.'?page='.$total_pages.'" title="Last">»</a></li>';
            }

            $pagination .= '</ul>';
        }
        return $pagination;
    }

    public functiom json($data) {
        if ($data != '') {
            return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
        } else {
            return false;
        }
    }

    /**
     * getImdbScrapeUrl
     *
     * Generates imdb.com URL to scrape
     *
     * @param  string $query Search query
     *
     * @return string        imdb.com URL to scrape
     *
     */
    public static function getImdbUrl($query)
    {
        // TODO: Sanitize $query
        $query = preg_replace('/ /', '+', $query);

        $base = 'http://www.imdb.com/search/title?title=';
        $end  = '&title_type=feature,tv_movie,tv_series,tv_special,documentary&sort=num_votes&!genres=Adult';
        return $base . $query . $end;
    }

    /**
     * scrape
     *
     * Scrapes URL and returns HTML
     *
     * @param  string $url URL to scrape
     *
     * @return string      HTML from URL
     *
     */
    public static function scrape($url)
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Accept-Language:en;q=0.8,en-US;q=0.6'));
        curl_setopt($handle, CURLOPT_URL, str_replace(' ', '%20', $url));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

        $html = curl_exec($handle);
        curl_close($handle);

        return $html;
    }

    /**
     * extractYear
     *
     * Extracts the year from a file/torrent name
     *
     * @param  string $title Filename, torrent name, etc
     *
     * @return string        The year
     *
     */
    public static function extractYear($title)
    {
        if ($title) {
            // Fine XXXX Year In Title
            preg_match('/([0-9]{4})/', $title, $matches);

            // If Found
            if (isset($matches[1])) {
                // Return Year
                return $matches[1];
            }
        }
        // No Year Found
        return false;
    }

    /**
     * extractImdbId
     *
     * Extracts the IMDB ID from name/data/string
     *
     * @param  string $data String of text that may contain IMDB ID
     *
     * @return string       IMDB ID
     *
     */
    public static function extractImdbId($data)
    {
        if (! empty($data)) {
            // Find IMDB ID
            preg_match('/(tt[0-9]+)\//', $data, $matches);

            // If Found
            if (isset($matches[1])) {
                // Return IMDB ID
                return $matches[1];
            }
        }
        // Not Found
        return false;
    }

    /**
     * 
     * magnet:?xt=urn:btih:TORRENT_HASH&dn=Url+Encoded+Movie+Name&tr=http://track.one:1234/announce&tr=udp://track.two:80
     * 
     * udp://tracker.coppersurfer.tk:6969
     * udp://tracker.leechers-paradise.org:6969
     * 
    **/
    
}
