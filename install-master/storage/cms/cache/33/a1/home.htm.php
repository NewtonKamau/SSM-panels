<?php 
class Cms5bcb2427c852b609110457_09d09c46bc0b9d7da314f4d16f2bf6dcClass extends Cms\Classes\PageCode
{
public function onPagePosts()
{
    $this->blogPosts->setProperty('pageNumber', post('page'));
    $this->pageCycle();
}
}
