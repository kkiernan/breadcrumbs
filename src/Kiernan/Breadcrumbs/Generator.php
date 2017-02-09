<?php

namespace Kiernan\Breadcrumbs;

class Generator
{
    /**
     * @var array
     */
    protected $crumbs = [];

    /**
     * Add a crumb to the trail.
     *
     * @param string $text
     * @param string $url
     */
    public function add($text, $url = null)
    {
        $this->crumbs[] = $this->makeCrumb($text, $url);
    }

    /**
     * Add a crumb to the trail if the given key is in the session.
     *
     * @param string $key
     */
    public function addIf($key)
    {
        if (session()->has($this->key($key))) {
            $this->crumbs[] = session($this->key($key));
        }
    }

    /**
     * Alias for addIf.
     *
     * @param string $key
     */
    public function addDynamic($key)
    {
        $this->addIf($key);
    }

    /**
     * Add many crumbs to the trail.
     *
     * @param array $crumbs
     */
    public function addMany(array $crumbs)
    {
        foreach ($crumbs as $crumb) {
            $text = isset($crumb[0]) ? $crumb[0] : '';
            $url = isset($crumb[1]) ? $crumb[1] : '';
            $this->crumbs[] = $this->makeCrumb($text, $url);
        }
    }

    /**
     * Put a crumb in the session.
     *
     * @param string $key
     * @param string $text
     * @param string $url
     */
    public function put($key, $text, $url)
    {
        session()->put($this->key($key), $this->makeCrumb($text, $url));
    }

    /**
     * Get a crumb from the session.
     *
     * @param string $key
     * @param string $text
     * @param string $url
     */
    public function get($key)
    {
        return session($this->key($key));
    }

    /**
     * Remove a sticky crumb from the session.
     *
     * @param string $key
     */
    public function forget($key)
    {
        session()->forget($this->key($key));
    }

    /**
     * Get the crumbs.
     *
     * @return array
     */
    public function all()
    {
        return $this->crumbs;
    }

    /**
     * Indicate whether or not the trail has more than one crumb.
     *
     * @return boolean
     */
    public function exist()
    {
        return count($this->crumbs) > 1;
    }

    /**
     * Make a crumb.
     *
     * @param string $text
     * @param string $url
     *
     * @return object
     */
    protected function makeCrumb($text, $url = null)
    {
        return (object) [
            'text' => $text,
            'url' => $url,
            'isActive' => is_null($url),
        ];
    }

    /**
     * Get the session key.
     *
     * @param string $key
     *
     * @return string
     */
    protected function key($key)
    {
        return "breadcrumbs.sticky_crumbs.$key";
    }
}
