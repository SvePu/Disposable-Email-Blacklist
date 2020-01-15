<?php

if (!defined("IN_MYBB"))
{
    die('Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.');
}

function disposemail_info()
{
    return array(
        'name' => 'Disposable Email Blacklist 2020',
        'description' => 'Blocks 7831 known anonymous, disposable, or spam email providers or services. Please feel free to suggest more blacklisted email providers.',
        'website' => 'https://community.mybb.com/mods.php?action=view&pid=1239',
        'author' => 'enespalit',
        'authorsite' => 'https://github.com/EnesPalit',
        'version' => '3.2.0',
        "codename" => "disposemail",
        'compatibility' => '18*'
    );
}

function disposemail_install()
{
    global $db;
    if(!$db->field_exists("bsource", "banfilters"))
    {
        $db->add_column("banfilters", "bsource", "varchar(20) NOT NULL DEFAULT 'user'");
    }
}

function disposemail_uninstall()
{
    global $db;
    if($db->field_exists("bsource", "banfilters"))
    {
        $db->drop_column("usergroups", "bsource");
    }
}

function disposemail_is_installed()
{
    global $db;
    if($db->field_exists('bsource', 'banfilters'))
    {
        return true;
    }
    return false;
}

function disposemail_activate()
{
    global $db, $cache;
    $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    foreach(glob($dir . 'dem_*.csv') as $demfile)
    {
        $fp = fopen($demfile, "r");
        while($email = fgetcsv($fp))
        {
            $replacement = array(
                'filter' => $email[0],
                'lastuse' => 0,
                'type' => 3,
                'dateline' => TIME_NOW,
                'bsource' => 'dispemail'
            );
            $db->replace_query('banfilters', $replacement);
        }
        fclose($fp);
    }
    $cache->update_bannedemails();
}

function disposemail_deactivate()
{
    global $db, $cache;
    $db->delete_query('banfilters', "bsource='dispemail'");
    $cache->update_bannedemails();
}
