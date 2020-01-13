<?php

if (!defined("IN_MYBB"))
{
    die('Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.');
}

function disposemail_info()
{
    return [
        'name' => 'Disposable Email Blacklist 2020',
        'description' => 'Blocks 7831 known anonymous, disposable, or spam email providers or services. Please feel free to suggest more blacklisted email providers.',
        'website' => 'https://community.mybb.com/mods.php?action=view&pid=1239',
        'author' => 'enespalit',
        'authorsite' => 'https://github.com/EnesPalit',
        'version' => '3.2.0',
        'compatibility' => '*',
    ];
}

function disposemail_install()
{
    global $db;
    $db->write_query("ALTER TABLE " . TABLE_PREFIX . "banfilters ADD bsource VARCHAR(20) NOT NULL DEFAULT 'user' AFTER dateline");
}

function disposemail_uninstall()
{
    global $db;
    $db->write_query("ALTER TABLE " . TABLE_PREFIX . "banfilters DROP bsource");
}

function disposemail_is_installed()
{
    global $db;
    return $db->field_exists('bsource', 'banfilters');
}

function disposemail_activate()
{
    global $db, $cache;
    $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    foreach (glob($dir . 'dem_*.csv') as $demfile) {
        $fp = fopen($demfile, "r");
        while ($email = fgetcsv($fp)) {
            $db->replace_query('banfilters', ['filter' => $email[0], 'lastuse' => 0, 'type' => 3, 'dateline' => TIME_NOW, 'bsource' => 'dispemail']);
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
