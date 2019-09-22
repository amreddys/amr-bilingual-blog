<?php

function localeHeadingClass()
{
    if(app()->getLocale() == "en")
        return 'english-heading';
    else
        return 'telugu-heading';
}
function localeBodyClass()
{
    if(app()->getLocale() == "en")
        return 'english-body';
    else
        return 'telugu-body text-2xl';
}