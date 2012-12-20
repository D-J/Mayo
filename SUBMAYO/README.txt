BUILDING A SUB-THEME WITH MAYO
------------------------------

I'm giving credit to the Zen theme here where I borrowed some of this readme.
The Zen Theme project is at http://drupal.org/project/zen and the full text of the README
in it's STARTERKIT is found there.

The whole idea is to use Mayo as a base theme and then make your own sub-theme off of
that so that you won't have to alter any files in the Mayo base theme.

1) To start copy the SUBMAYO folder to sites/all/themes/ and rename it according to Drupal
conventions. IMPORTANT: The name of your sub-theme must start with an alphabetic character
and can only contain lowercase letters, numbers and underscores. For the basis of this example
we will say the name is "mymayo", but it can be anything. So now you would have sites/all/themes/mymayo.

2) In your new sub-theme folder, rename SUBMAYO.info.txt with the theme name you selected and remove
the .txt. It would look like mymayou.info now. Edit the name and description at the top of this file.
Then, visit your site's Appearance page at admin/appearance to refresh Drupal 7's cache of .info file data.

3) Now go into admin/appearance and set your new Sub-Theme to "Enable and set default". This assumes that
that you already have Mayo installed.

This is just a quick example of how you can make a sub-theme of Mayo with the Color module. For more
documentation on sub-themes in Drupal 7 check:

http://drupal.org/node/193318
    and Drupal 7's Theme Guide online at:
      http://drupal.org/theme-guide
