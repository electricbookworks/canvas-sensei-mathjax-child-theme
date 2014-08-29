# canvas-sensei-mathjax-child-theme

This is a Canvas child theme for Sensei to enable MathJax in quizzes

This child theme was developed for a specific once-off task: to enable MathJax in quizzes created with Woothemes Sensei plugin and the Woothemes Canvas theme. It was developed by [Lightspeed](http://lsdev.biz) for [Electric Book Works](http://electricbookworks.com).

* We used the [Canvas theme from WooThemes](http://www.woothemes.com/products/canvas/)
* We installed the WooThemes [Sensei plugin]((http://www.woothemes.com/products/sensei/) and the [MathJax-Latex plugin](http://wordpress.org/plugins/mathjax-latex/) from the guys at [Knowledge Blog](http://knowledgeblog.org/mathjax-latex-wordpress-plugin).
* Sensei uses custom fields for its quizzes, but Wordpress strips out the MathJax in these fields before MathJax-Latex can parse it (probably a consequence of Wordpress's built-in security measures). So our child theme includes functions (in `include/MathJax_Sensei_Fix.php`) that fix this, allowing us to use MathJax in the Sensei quizzes inside `[latex][/latex]` shortcodes. The only tweak was that we have to use pipes `|` instead of slashes `/` in the Latex notation, e.g. `[latex]|frac{12}{17}[/latex]`, not `[latex]\frac{12}{17}[/latex]`.
* The child theme also allows us to include images in the quizzes by using HTML `<img>` tags. Since we developed our child theme in 2013, Woothemes have added support for images in Sensei quizzes. So using this child theme you can either use `<img>` tags or Sensei's built-in function for adding images to quizzes.

We don't actively support this theme, since we no longer maintain [the site it was built for](http://trainingteachers.org.za). Should you need further development on it, we recommend contacting Lightspeed. Alternatively, a good Wordpress/PHP developer should be able to adapt it.
