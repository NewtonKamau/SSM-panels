<?php 
class Cms5bcb2cfdcf6de993005493_e6225845fa1f724533668c806d2761f4Class extends Cms\Classes\PageCode
{
public function onEnd()
{
    if ($this->post) {
        $this->page->title = $this->post->title;
    }
    else {
        return Redirect::to($this->pageUrl('404'));
    }
}
}
