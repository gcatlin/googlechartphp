# GoogleChartPHP #
An easy to use wrapper for the [Google Chart API](http://code.google.com/apis/chart/) written in [PHP](http://php.net/) utilizing a [fluent interface](http://en.wikipedia.org/wiki/Fluent_interface).

See GettingStarted for a quick guide to getting started with GoogleChartPHP.

# Features #
**GoogleChartPHP currently implements only a small subset of the Google Chart API.** The RoadMap has more details.

If you need a more full-feature library, check out the [Google Chart API Related links page](http://groups.google.com/group/google-chart-api/web/useful-links-to-api-libraries).

# Design Goals #
  * provide an easy to use, lightweight interface
  * make it really easy to create attractive/effective charts (it's not there yet)
  * make it really easy to add custom chart types (histogram, bullet graph, function plot, cycle plot, etc.)
  * fully unit tested w/ 100% code coverage

# Installation #
Download the [latest release](http://code.google.com/p/googlechartphp/downloads/list) and extract.

# Simple Example #
![http://chart.apis.google.com/chart?cht=lc&chs=200x100&chd=s:9jRJA&ext=.png](http://chart.apis.google.com/chart?cht=lc&chs=200x100&chd=s:9jRJA&ext=.png)

```
<?php

require 'GoogleChart.php';
echo GoogleChart::LineChart()->data(80,50,30,20,10)->size(200,100)->img();

?>
```