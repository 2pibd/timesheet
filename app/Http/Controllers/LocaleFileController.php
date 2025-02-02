<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Lang;

class LocaleFileController extends Controller
{
    private $lang = '';
    private $file;
    private $key;
    private $value;
    private $path;
    private $arrayLang = array();

    private function changeLangFileContent($lang, $file, $key, $value)
    {
        $this->read();
        $this->arrayLang[$this->key] = $this->value;
        $this->save();
    }

    private function deleteLangFileContent()
    {
        $this->read();
        unset($this->arrayLang[$this->key]);
        $this->save();
    }

    private function read()
    {
        if ($this->lang == '') $this->lang = App::getLocale();
        $this->path = base_path().'/resources/lang/'.$this->lang.'/'.$this->file.'.php';
        $this->arrayLang = Lang::get($this->file);
        if (gettype($this->arrayLang) == 'string') $this->arrayLang = array();
    }

    private function save()
    {
        $content = "<?php\n\nreturn\n[\n";

        foreach ($this->arrayLang as $this->key => $this->value)
        {
            $content .= "\t'".$this->key."' => '".$this->value."',\n";
        }

        $content .= "];";

        file_put_contents($this->path, $content);
    }
}
