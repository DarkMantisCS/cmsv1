// Setup the dynamic Grid Sys
var ADAPT_CONFIG = {
  // Where is your CSS?
  path: 'http://localhost/cms/images/',

  /* false = Only run once, when page first loads.
   * true = Change on window resize and page tilt.
   */
  dynamic: true,

  /* First range entry is the minimum.
   * Last range entry is the maximum.
   * Separate ranges by "to" keyword.
   */
  range: [
    '0px to 760px = grid.mobile.css',
    '760px to 980px = grid.720.css',
    '980px to 1280px = grid.960.css',
    '1280px to 1600px = grid.1200.css',
    '1600px to 1920px = grid.1560.css',
    '1920px = grid.fluid.css'
  ]
};
