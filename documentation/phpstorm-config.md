## Useful shortcuts

* `alt` + `1`: Open the file navigation tree view (left bar)
* `ctrl` + `alt` + `s`: Open Settings
* `shift` + `shift`: Global search
* `alt` + `home`: Navigation bar
* `alt` + `insert` *(while exploring files)*: New file
* `ctrl` + `alt` + `l`: Reformat code (correct tabbing and spacing)
* `ctrl` + `f12`: See member functions in a file
* `alt` + `f12`: Open the embeded terminal
* *(custom)* `ctrl` + `PgUp`: When editor is split, move to editor to the right
* *(custom)* `ctrl` + `PgDn`: When editor is split, move to editor to the left
* *(custom)* `ctrl` + `shift` + `PgUp`: Split editor vertically
* *(custom)* `ctrl` + `shift` + `PgDn`: Un-split editor

## Configure custom shortcuts

In order to modify the keymap, just open settings and search for *keymap*. After finding the keymap, go ahead and duplicate the current configuration to make sure you preserve the base configuration. In my setup, "**GNOME**" is the selected keymap, go ahead and click on the gear to the right and click "**duplicate**" option.

* **Split editor**: I like to split my editor vertically all the time. To achieve this, search *split right* and add the binding that you desire; I use `ctrl` + `shift` + `PgUp`
* **Un-split editor**: I like to split my editor vertically and toggle between split view and single view. To achieve this, search *unsplit* and add the binding that you desire; I use `ctrl` + `shift` + `PgDn`
* **Move to right editor**: Since I work with my editor split vertically, I'll want to navigate from one editor to the other (left to right). To achieve this, search *Goto Next Splitter* and add the binding that you desire; I use `ctrl` + `PgUp`
* **Move to left editor**: Since I work with my editor split vertically, I'll want to navigate from one editor to the other (right to left). To achieve this, search *Goto Previous Splitter* and add the binding that you desire; I use `ctrl` + `PgDn`

## Make it beautiful

I work on my IDE all day long, I want it to be pleasing to the eye, let's make it pretty.

1. **Install Material theme**
   1. Open settings and search for plugins
   2. Within the plugins search, search for *Material Theme UI*
   3. Install it
   4. IDE might ask to restart
   5. After installing, you can configure the "Material Theme UI" plugin
      1. Open settings and search for the plugin (it'll be under `Appearance and Behavior > Material Theme`
      2. The only thing I modify is the `Selected Theme` option, I select "**Arc Dark**"
2. **Adjust font**
   1. Enable font ligatures
      1. Open settings and go to `Editor` > `Font`
      2. Enable ligatures by clicking the "**Enable font ligatures**" checkbox.
   2. Update font sizes
      1. Open settings and go to `Editor` > `Color Scheme` > `Color Scheme Font`
      2. Based on prior steps, you'd have the "**Arc Dark**" scheme selected at this point, click on the gear next to it and click the "**duplicate**" option. The UI will ask you to name the new scheme, name it as you'd like.
      3. Now that you've forked the theme, we can edit it without risking our base configuration.
      4. I like to set the following
         1. Font: `JetBrains Mono`
         2. Font size: `14`
         3. Line spacing: `1.3`
         4. Enable ligatures: `checked`

## Remove Clutter

I don't like clutter in my IDE, I'm familiar with how it works, I'm a keyboard centric user; let's get rid of all of the clutter that takes up screen real estate.

1. **Remove breadcrumbs**
   1. Open settings and search for *breadcrumbs*
   2. Just un-check the *Show breadcrumbs* option
2. **Get rid of tabs**
   1. Open settings and search for *tabs*
   2. Set the `Tab Placement` option to *none*
3. **Remove the bottom status bar**
   1. Open settings and search for *status* or you can use the global search and do the same search.
   2. Disable the status bar
4. **Remove the browser tabs**
   1. Open settings and search for *browser*
   2. In the section that's called `Show browser popup in the editor` un-check all of the options.
5. **Get rid of unnecessary menus**
   1. Get rid of the `Navigation Bar Toolbar`
      1. Open settings and search for *menu*
      2. Turn off the following
         1. `Navigation Bar Toolbar`
   2. Get rid of the `Navigation Bar`
      1. Go to the `View` menu > `Appearance` > Toggle `Navigation Bar`
   3. Get rid of the `Tool Window Bars`
      1. Go to the `View` menu > `Appearance` > Toggle `Tool Window Bars`
   4. Get rid of the `Main Menu`
      1. Go to the `View` menu > `Appearance` > Toggle `Main Menu`
      2. You can actually access your main menu from the global search, search *main menu* and it'll appear there for you (so you don't need to see it all the time).

## Customize Editor

I don't customize the editor very much, but I do like guides at the `80` and `120` character mark, among a few other things.

* Add visual guides
  * Make sure they're visible by;
    * Opening Settings
    * Go to `Editor` > `Color Scheme` > `General`
    * On the right side of the General view, go to Editor > Guides > Visual Guides and select the color you'd like to use for the foreground property (I like to use `#2F343F`).
  * Configure the guides by;
    * Opening Settings
    * Go to `Editor` > `Code Style`
    * On the right side of the Code Style view, go to the General tab and click on the visual guides input; configure as you'd like (I like guides at `80`, `100` and `120` characters so: `80, 100, 120`).
* If you use **EditorConfig** plugin you may want to make sure that the contents of the `.editorconfig` override your PHPStorm settings; to do this,
  * Open Settings
  * Go to `Editor` > `Code Style`
  * On the right side of the Code Style view, go to the General tab en check the *Enable EditorConfig support* setting.
* Set the PHP version for the project
  * Open Settings
  * Go to `Languages & Frameworks` > `PHP`
  * The *PHP Language Level* setting has the version for the current project
* I like my JS files to be set to `2` spaces
  * Open Settings
  * Go to `Editor` > `Code Style` > `JavaScript`. I like to set the JS preferences as follows
    * *Tab Size*: `2`
    * *Indent*: `2`
    * *Continuation indent*: `2`
    * *Keep indents on empty lines*: unchecked
    * *Indent chained methods*: checked
    * *Indent all chained calls in a group*: unchecked