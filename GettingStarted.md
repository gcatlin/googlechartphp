

# Installation #
Download the [latest release](http://code.google.com/p/googlechartphp/downloads/list) and extract.

# Basic Usage #
## Instantiation ##
You can instantiate a chart object using the `new` operator
```
$chart = new GoogleChart_LineChart(); // equivalent to the example below
```

Or, you can use one of the static [factory methods](http://en.wikipedia.org/wiki/Factory_method_pattern)
```
$chart = GoogleChart::LineChart(); // equivalent to the example above
```

However, you can't instantiate a generic chart object
```
$chart = new GoogleChart(); // doesn't work!
```

## Fluent interface ##
GoogleChartPHP has a [fluent interface](http://en.wikipedia.org/wiki/Fluent_interface), so you can use [method chaining](http://en.wikipedia.org/wiki/Method_chaining) to instantiate, configure, and output the chart
```
echo GoogleChart::LineChart()->data(80,50,30,20,10)->size(200,100)->url();
```

## Data ##
You can supply data in several ways
```
$chart = new GoogleChart_LineChart(array(1, 2, 3));
echo $chart->url();

echo GoogleChart::LineChart(array(1, 2, 3))->url();

echo GoogleChart::LineChart()->data(array(1, 2, 3))->url();

echo GoogleChart::LineChart()->data(1, 2, 3)->url();

// These all output the same URL
// http://chart.apis.google.com/chart?cht=lc&chs=250x100&chd=s:9jRJA
```

If you don't specify any data, your chart will be empty; which is kinda lame for a chart
```
echo GoogleChart::LineChart()->url();
// http://chart.apis.google.com/chart?cht=lc&chs=250x100
```

## Size ##
If you don't specify a size, it will default to 250 px wide by 100 px tall
```
echo GoogleChart::LineChart()->data(80,50,30,20,10)->url();
// http://chart.apis.google.com/chart?cht=lc&chs=250x100&chd=s:9jRJA
```

## Output ##
You can output just the URL
```
echo GoogleChart::LineChart()->data(80,50,30,20,10)->size(200,100)->url();
// http://chart.apis.google.com/chart?cht=lc&chs=200x100&chd=s:9jRJA
```

Or, you can output an entire `<img>` tag
```
echo GoogleChart::LineChart()->data(80,50,30,20,10)->size(200,100)->img();
// <img src="http://chart.apis.google.com/chart?cht=lc&chs=200x100&chd=s:9jRJA" width="200" height="100" alt="Chart">
```

# Examples #
## Line Chart ##
![http://chart.apis.google.com/chart?cht=lc&chs=200x100&chd=s:9jRJA&ext=.png](http://chart.apis.google.com/chart?cht=lc&chs=200x100&chd=s:9jRJA&ext=.png)
```
echo GoogleChart::LineChart()->data(80,50,30,20,10)->size(200,100)->img();
```

## Bar Chart ##
![http://chart.apis.google.com/chart?cht=bvg&chs=200x100&chd=s:9jRJA&ext=.png](http://chart.apis.google.com/chart?cht=bvg&chs=200x100&chd=s:9jRJA&ext=.png)
```
echo GoogleChart::BarChart()->data(80,50,30,20,10)->size(200,100)->img();
```

## Pie Chart ##
![http://chart.apis.google.com/chart?cht=p&chs=200x100&chd=s:9jRJA&ext=.png](http://chart.apis.google.com/chart?cht=p&chs=200x100&chd=s:9jRJA&ext=.png)
```
echo GoogleChart::PieChart()->data(80,50,30,20,10)->size(200,100)->img();
```

## Venn Diagram ##
![http://chart.apis.google.com/chart?cht=v&chs=200x100&chd=s:9lVMGDA&ext=.png](http://chart.apis.google.com/chart?cht=v&chs=200x100&chd=s:9lVMGDA&ext=.png)
```
echo GoogleChart::VennDiagram()->data(210,130,80,50,30,20,10)->size(200,100)->img();
```

## Scatter Plot ##
![http://chart.apis.google.com/chart?cht=s&chs=200x100&chd=s:kAU,FK9&ext=.png](http://chart.apis.google.com/chart?cht=s&chs=200x100&chd=s:kAU,FK9&ext=.png)
```
echo GoogleChart::ScatterPlot()->data(array(80,10,50),array(20,30,130))->size(200,100)->img();
```

## Radar Chart ##
![http://chart.apis.google.com/chart?cht=r&chs=200x100&chd=s:9jRJA&ext=.png](http://chart.apis.google.com/chart?cht=r&chs=200x100&chd=s:9jRJA&ext=.png)
```
echo GoogleChart::RadarChart()->data(80,50,30,20,10)->size(200,100)->img();
```

## Map ##
![http://chart.apis.google.com/chart?chtm=world&cht=t&chs=200x100&chd=s:9jRJA&ext=.png](http://chart.apis.google.com/chart?chtm=world&cht=t&chs=200x100&chd=s:9jRJA&ext=.png)
```
echo GoogleChart::Map()->data(80,50,30,20,10)->size(200,100)->img();
```

## Googleometer ##
![http://chart.apis.google.com/chart?cht=gom&chs=200x100&chd=s:A&ext=.png](http://chart.apis.google.com/chart?cht=gom&chs=200x100&chd=s:A&ext=.png)
```
echo GoogleChart::Googleometer()->data(80)->size(200,100)->img();
```

## QR Code ##
![http://chart.apis.google.com/chart?cht=qr&chs=200x100&chd=s:9jRJA&ext=.png](http://chart.apis.google.com/chart?cht=qr&chs=200x100&chd=s:9jRJA&ext=.png)
```
echo GoogleChart::QRCode()->data(80,50,30,20,10)->size(200,100)->img();
```