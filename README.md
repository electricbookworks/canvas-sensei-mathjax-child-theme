# A Canvas child theme for Sensei to enable MathJax in quizzes

This child theme was developed in 2013 for a specific once-off task: to enable MathJax in quizzes created with Woothemes Sensei plugin and the Woothemes Canvas theme on an early version of [trainingteachers.org.za](http://trainingteachers.org.za). It was developed by [LightSpeed](http://lsdev.biz) for [Electric Book Works](http://electricbookworks.com).

## At your own risk

You use this code at your own risk entirely. We take no responsibility for anything that might happen when you use it. **Do not use this on a live production installation before thoroughly testing it on a separate staging installation.**

## Installation

* You need to be very familiar with self-hosted Wordpress installations.
* You'll need Wordpress with [Canvas](http://www.woothemes.com/products/canvas/), [Sensei](http://www.woothemes.com/products/sensei/) and the [MathJax-Latex plugin](http://wordpress.org/plugins/mathjax-latex/) installed.
* Put the `canvas-sensei-mathjax-child-theme` folder in your Wordpress installation's `themes` folder.
* Read the background below, especially the bit about using pipes `|`.

## Background and tips

Our client needed a site with lessons and quizzes to teach teachers about teaching primary-school maths.

* We used the [Canvas theme from WooThemes](http://www.woothemes.com/products/canvas/).
* We installed the WooThemes [Sensei plugin](http://www.woothemes.com/products/sensei/) and the [MathJax-Latex plugin](http://wordpress.org/plugins/mathjax-latex/) from the guys at [Knowledge Blog](http://knowledgeblog.org/mathjax-latex-wordpress-plugin).
* Sensei uses custom fields for its quizzes, but Wordpress strips out the MathJax in these fields before MathJax-Latex can parse it (probably a consequence of Wordpress's built-in security measures). 
* So our child theme gets around this with functions (in `include/MathJax_Sensei_Fix.php`) that override this behaviour for MathJax-Latex, allowing us to use MathJax-Latex notation in the Sensei quizzes inside `[latex][/latex]` shortcodes. Importantly, we have to use pipes `|` instead of slashes `/` in the Latex notation, e.g. `[latex]|frac{12}{17}[/latex]`, not `[latex]\frac{12}{17}[/latex]`.
* The child theme also allows us to include images in the quizzes by using HTML `<img>` tags. At the time, Sensei did not support images in quizzes out the box. Woothemes have since added support for images in Sensei quizzes. So using this child theme you can either use `<img>` tags or Sensei's built-in function for adding images to quizzes.

We don't actively support this theme, since we no longer maintain [the site it was built for](http://trainingteachers.org.za). Should you need further development on it, we recommend contacting [LightSpeed](http://www.lsdev.biz). Alternatively, a good Wordpress/PHP developer should be able to adapt it.
