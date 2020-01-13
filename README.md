# MyBB Disposable Email Blacklist (Updated - 2020)
MyBB Plugin which blocks 7814 known anonymous, disposable, or spam email providers or services.

Originally created by Depressurize and updated by Stardust342, I have merged both plugins into one and used martensons git (https://github.com/martenson/disposable-email-domains) as update source.

Original Plugin Link (Depressurize): http://community.mybb.com/mods.php?action=view&pid=293
Original Plugin Link (Stardust342): https://community.mybb.com/mods.php?action=view&pid=603

<h1>Version 3.2.0</h1>
Now using csv files as mail database. You can add mails in the existing 'dem_init.csv' file or create a new file. If creating new files, their name must begin with 'dem_' and they must be '.csv'.

<h2>Installing</h2> 
1) Merge the inc folder with the one on the root directory of your MyBB Webserver.
2) Install & Activate it from your Plugin Configuration page of your MyBB Website.

<h2>Uninstalling</h2>
Uninstall it from your Plugin Configuration page of your MyBB Website.

<h2>Updating DB</h2>
If you add or remove emails from the .csv datafile(s), just deactivate and reactivate the plugin.

<em>Please feel free to suggest more blacklisted email providers.</em>
