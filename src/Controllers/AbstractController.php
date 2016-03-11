<?php

namespace Attrox\ConfigController\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller as ControllerBase;
use October\Rain\Config\Repository;

abstract class AbstractController extends ControllerBase
{
    protected $config_base = 'configcontroller'; // This is mapped to Laravel config/configcontroller.php
    protected $admin_view = 'config_admin'; // This is the blade view used by the admin
    protected $index_view = '';
    protected $config; // October\Rain\Config\Repository object

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function index(Request $request, $slug)
    {
        if (!$this->hasSlug($slug)) abort(404, "The page {$slug} does not exist");

        $content = $this->getSlugContent($slug);

        return view($this->index_view, compact('content'));
    }

    /**
     * Display the administration part where user can view and edit the configuration
     * @param $slug
     */
    public function admin(Request $request, $slug)
    {
        if (!$this->hasSlug($slug)) abort(404, "The page {$slug} does not exist");

        $input = $this->getSlugInput($slug);
        $content = (session('slug_content')) ? session('slug_content') : $this->getSlugContent($slug);
        $alert_msg = (session('alert_msg')) ? session('alert_msg') : '';

        if ($this->admin_view == '') abort(404, "No view is associated with this page");

        return view($this->admin_view, compact('input', 'content', 'alert_msg'));
    }

    public function adminPost(Request $request, $slug)
    {
        if (!$this->hasSlug($slug)) abort(404, "The page {$slug} does not exist");

        // Get current config content
        $content = $this->getSlugContent($slug);

        $update = array();
        foreach ($request->input() as $key => $value) {
            if (isset($content[$key])) {
                $update[$key] = $value;
                $content[$key] = $value;
            }
        }

        $base = $this->config_base;
        foreach ($update as $key => $value) {
            $this->config->write("{$base}.content.{$slug}.{$key}", addslashes($value));
        }

        // Redirect with flash data since Config files are normally cached to show the updated content
        return back()->with(['slug_content' => $content, 'alert_msg' => 'Update successful']);
    }

    protected function setConfigBase($name)
    {
        $this->config_base = $name;
    }

    protected function setAdminView($filename)
    {
        $this->admin_view = $filename;
    }

    protected function setIndexView($filename)
    {
        $this->index_view = $filename;
    }

    protected function hasSlug($slug)
    {
        $base = $this->config_base;
        $config = $this->config;

        if (!$config->get("{$base}.slug")) return false;
        if (!in_array($slug, $config->get("{$base}.slug"))) return false;

        return true;
    }

    protected function getSlugInput($slug)
    {
        $base = $this->config_base . ".input.{$slug}";
        $config = $this->config;

        if (!$input = $config->get($base)) return [];

        return $input;
    }

    protected function getSlugContent($slug)
    {
        $base = $this->config_base;
        $config = $this->config;

        $content = $config->get("{$base}.content.{$slug}");
        if (!$content) return [];

        return $content;
    }
}