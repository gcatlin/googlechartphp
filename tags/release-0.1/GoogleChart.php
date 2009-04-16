<?php

// Copyright 2009 Geoff Catlin
// 
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
// 
//     http://www.apache.org/licenses/LICENSE-2.0
// 
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

class GoogleChart {
	
	const Url = 'http://chart.apis.google.com/chart';
	
	const Type_LineChart = 'lc';
	const Type_LineChart_XY = 'lxy';
	const Type_Sparkline = 'ls';
	const Type_BarChart_HorizontalStacked = 'bhs';
	const Type_BarChart_HorizontalGrouped = 'bhg';
	const Type_BarChart_VerticalStacked = 'bvs';
	const Type_BarChart_VerticalGrouped = 'bvg';
	const Type_PieChart = 'p';
	const Type_PieChart_3d = 'p3';
	const Type_PieChart_Concentric = 'pc';
	const Type_VennDiagram = 'v';
	const Type_ScatterPlot = 's';
	const Type_RadarChart = 'r';
	const Type_RadarChart_Splined = 'rs';
	const Type_Map = 't';
	const Type_Googleometer = 'gom';
	const Type_QRCode = 'qr';
	
	const Encoding_Extended = 'e';
	const Encoding_Simple = 's';
	const Encoding_Text = 't';
	
	const Param_Data = 'chd';
	const Param_Size = 'chs';
	const Param_Type = 'cht';
	const Param_Title = 'chtt';	
	const Param_TitleStyle = 'chts';
	const Param_Color = 'chco';
	// const Param_Legend = 'chdl';
	// const Param_LegendPosition = 'chdlp';
	// const Param_TitleStyle = 'chts';
	// const Param_AxisLabel = 'chxl';
	// const Param_AxisLabelPosition = 'chxp';
	// const Param_AxisRange = 'chxr';
	// const Param_AxisStyle = 'chxs';
	// const Param_AxisTickMark = 'chxtc';
	// const Param_AxisType = 'chxt';
	// const Param_Margin = 'chma';
	// const Param_Marker = 'chm';
	// const Param_Grid = 'chg';
	// const Param_LineStyle = 'chls';
	// const Param_BarWidth = 'chbh';
	// 
	// const Legend_Bottom = 'b';
	// const Legend_Top = 't';
	// const Legend_Right = 'r';
	// const Legend_Left = 'l';
	// 
	// const Marker_Arrow = 'a';
	// const Marker_Circle = 'o';
	// const Marker_Cross = 'c';
	// const Marker_Diamond = 'd';
	// const Marker_Fill = 'b';
	// const Marker_FillOne = 'B';
	// const Marker_HorizontalLine = 'h';
	// const Marker_Square = 's';
	// const Marker_VerticalLine = 'v';
	// const Marker_VerticalLineFull = 'V';
	// const Marker_X = 'x';
	// 
	// const Axis_Right = 'r';
	// const Axis_Top = 't';
	// const Axis_X = 'x';
	// const Axis_Y = 'y';

	const Max_Area = 300000;
	const Max_Width = 1000;
	const Max_Height = 1000;
	
	const Default_Width = 250;
	const Default_Height = 100;
	
	static protected $encoding_methods = array(
		'e' => 'encodeExtended',
		's' => 'encodeSimple',
		't' => 'encodeText');
	static protected $extended_map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-.';
	static protected $simple_map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	static protected $encoded_params = array('chtt' => 1); 

	protected $colors = null;
	protected $data = null;
	protected $encoding = null;
	// protected $markers = array();
	protected $params = null;
	protected $size = null;
	protected $title = null;
	protected $title_color = null;
	protected $title_size = null;
	protected $type = null;
	
	public static function LineChart($data=null, $size=null) {
		return new GoogleChart_LineChart($data, $size);
	}

	public static function Sparkline($data=null, $size=null) {
		return new GoogleChart_Sparkline($data, $size);
	}

	public static function BarChart($data=null, $size=null) {
		return new GoogleChart_BarChart($data, $size);
	}

	public static function PieChart($data=null, $size=null) {
		return new GoogleChart_PieChart($data, $size);
	}

	public static function VennDiagram($data=null, $size=null) {
		return new GoogleChart_VennDiagram($data, $size);
	}

	public static function ScatterPlot($data=null, $size=null) {
		return new GoogleChart_ScatterPlot($data, $size);
	}

	public static function RadarChart($data=null, $size=null) {
		return new GoogleChart_RadarChart($data, $size);
	}

	public static function Map($data=null, $size=null) {
		return new GoogleChart_Map($data, $size);
	}

	public static function Googleometer($data=null, $size=null) {
		return new GoogleChart_Googleometer($data, $size);
	}

	public static function QRCode($data=null, $size=null) {
		return new GoogleChart_QRCode($data, $size);
	}

	protected function __construct($type=null, $data=null, $size=null) {
		$this->type($type)->data($data)->size($size);
	}
	
	protected function __get($name) {
		if (isset($this->$name)) {
			return $this->$name;
		}
		return null;
	}
	
	protected function __toString() {
		return $this->url();
	}
	
	public function colors() {
		$this->colors = func_get_args();
		return $this;
	}

	public function data($data) {
		$argc = func_num_args();
		if ($argc) {
			if ($argc == 1) {
				if (is_array($data) && !is_array(reset($data))) {
					$data = array($data);
				} elseif ($data !== null && !is_array($data)) {
					$data = array(array($data));
				}
			} else {
				if (is_array($data)) {
					$data = func_get_args();
				} else {
					$data = array(func_get_args());
				}
			}
			$this->data = $data;
		}
		return $this;
	}
	
	public function encoding($encoding) {
		$this->encoding = $encoding;
		return $this;
	}
	
	public function img() {
		$url = $this->url;
		list($width, $height) = $this->size;
		$title = htmlspecialchars($this->title);
		if (strpos($title, '|') !== false) {
			$title = str_replace('|', ' | ', $title);
		}
	
		$img = '<img src="%s" width="%d" height="%d" title="%s" alt="Chart">';
		return sprintf($img, array($url, $width, $height, $title));
	}
	
	public function param($name, $value) {
		$this->params[$name] = $value;
		return $this;
	}
	
	public function size($width, $height=null) {
		if ($width === null && $height === null) {
			$this->size = null;
			return $this;
		}
		
		if ($height === null && is_array($width)) {
			list($width, $height) = $width;
		}
		
		$width = (int) $width;
		$height = (int) $height;

		if ($width <= 0 || $height <= 0) {
			$width = max(1, $width, $height);
			$height = $width;
		}
		
		$scale = 0;
		if (self::Max_Width < $width || self::Max_Height < $height) {
			if ($width / $height >= 1) {
				$scale = self::Max_Width / $width;
			} else {
				$scale = self::Max_Height / $height;
			}
			$width *= $scale;
			$height *= $scale;
		}

		$area = $width * $height;
		if (self::Max_Area < $area)  {
			$scale = sqrt(self::Max_Area / $area);
			$width *= $scale;
			$height *= $scale;
		}
		
		if ($scale != 0) {
			$width = max(1, floor($width));
			$height = max(1, floor($height));
		}
		
		$this->size = array($width, $height);

		return $this;
	}
	
	public function title($title, $color=null, $size=null) {
		$this->title = $title;
		$this->title_color = $color;
		$this->title_size = $size;
		return $this;
	}
	
	public function url() {
		$params = (array) $this->params;
		
		$type = $this->type;
		if ($type !== null) {
			$params[self::Param_Type] = $type;
		}

		list($width, $height) = $this->size;
		if ($width === null) {
			$width = self::Default_Width;
			$height = self::Default_Height;
		}
		$params[self::Param_Size] = $width;
		if ($height != $width) {
			$params[self::Param_Size] .= 'x'.$height;
		}

		$data = $this->data;
		if ($data) {
			$min = min($data[0]);
			$max = max($data[0]);
			for ($i = 1, $imax = count($data); $i < $imax; $i++) {
				$min = min($min, min($data[$i]));
				$max = max($max, max($data[$i]));
			}

			$encoding = $this->encoding;
			if ($encoding === null) {
				$encoding = self::Encoding_Simple;
			}

			if (isset(self::$encoding_methods[$encoding])) {
				$encode_method = self::$encoding_methods[$encoding];
				$encoded = $this->$encode_method($data, $min, $max);
			}
			$params[self::Param_Data] = $encoding.':'.$encoded;

			$colors = $this->colors;
			if ($colors) {
				$params[self::Param_Color] = implode(',', array_slice($colors, 0, count($data)));
			}
		}
		
		$title = $this->title;
		if ($title !== null) {
			$params[self::Param_Title] = $title;
			if ($this->title_color !== null) {
				$params[self::Param_TitleStyle] = $this->title_color;
				if ($this->title_size !== null) {
					$params[self::Param_TitleStyle] .= ','.$this->title_size;
				}
			}
		}
	
		$query = array();
		foreach ($params as $key => $value) {
			if ($value && isset(self::$encoded_params[$key])) {
				$encoded = urlencode($value);
				$value = str_replace(array('%7C', '%2C', '%3A'), array('|', ',', ':'), $encoded);
			}
			$query[] = $key.'='.$value;
		}
		$query = implode('&', $query);
	
		return self::Url.'?'.$query;
	}
	
	protected function encodeExtended($data, $min, $max) {
		$scale = 4095 / ($min == $max ? 1 : $max - $min);

		$encoded = array();
		foreach ($data as $i => $series) {
			foreach ($series as $value) {
				if ($min <= $value && $value <= $max && is_numeric($value)) {
					$scaled = round($scale * ($value - $min));
					$encoded[$i] .= self::$extended_map[$scaled / 64].self::$extended_map[$scaled % 64];
				} else {
					$encoded[$i] .= '__';
				}
			}
		}

		return implode(',', $encoded);
	}

	protected function encodeSimple($data, $min, $max) {
		$scale = 61 / ($min == $max ? 1 : $max - $min);

		$encoded = array();
		foreach ($data as $i => $series) {
			foreach ($series as $value) {
				if ($min <= $value && $value <= $max && is_numeric($value)) {
					$scaled = round($scale * ($value - $min));
					$encoded[$i] .= self::$simple_map[$scaled];
				} else {
					$encoded[$i] .= '_';
				}
			}
		}
		return implode(',', $encoded);
	}

	protected function encodeText($data, $min, $max) {
		$scale = 100 / ($min == $max ? 1 : $max - $min);
	
		$encoded = array();
		foreach ($data as $i => $series) {
			foreach ($series as $value) {
				if ($min <= $value && $value <= $max && is_numeric($value)) {
					$scaled = $scale * ($value - $min);
					$encoded[$i] .= round($scaled, 1).',';
				} else {
					$encoded[$i] .= '-1,';
				}
			}
			$encoded[$i] = rtrim($encoded[$i], ',');
		}

		return implode('|', $encoded);
	}

	protected function type($type) {
		$this->type = $type;
		return $this;
	}
	
}

class GoogleChart_LineChart extends GoogleChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_LineChart)->data($data)->size($size);
	}
}

class GoogleChart_Sparkline extends GoogleChart_LineChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_Sparkline)->data($data)->size($size);
	}
}

class GoogleChart_BarChart extends GoogleChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_BarChart_VerticalGrouped)->data($data)->size($size);
	}
}

class GoogleChart_PieChart extends GoogleChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_PieChart)->data($data)->size($size);
	}
}

class GoogleChart_VennDiagram extends GoogleChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_VennDiagram)->data($data)->size($size);
	}
}

class GoogleChart_ScatterPlot extends GoogleChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_ScatterPlot)->data($data)->size($size);
	}
}

class GoogleChart_RadarChart extends GoogleChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_RadarChart)->data($data)->size($size);
	}
}

class GoogleChart_Map extends GoogleChart {
	const Max_Width = 440;
	const Max_Height = 220;
	
	const Param_Map = 'chtm';

	const Area_Africa  = 'africa';
	const Area_Asia = 'asia';
	const Area_Europe = 'europe';
	const Area_MiddleEast = 'middle_east';
	const Area_SouthAmerica = 'south_america';
	const Area_USA = 'usa';
	const Area_World = 'world';
	
	protected $area = null;
	protected $params = array('chtm' => 'world');
	
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_Map)->data($data)->size($size);
	}
	
	public function area($area) {
		$this->area = $area;
		return $this;
	}
	
	public function size($width, $height=null) {
		parent::size($width, $height);

		list($width, $height) = $this->size;		
		if (self::Max_Width < $width || self::Max_Height < $height) {
			if ($width / $height >= 1) {
				$scale = self::Max_Width / $width;
			} else {
				$scale = self::Max_Height / $height;
			}
			$width = max(1, floor($width * $scale));
			$height = max(1, floor($height * $scale));

			$this->size = array($width, $height);
		}

		return $this;
	}
}

class GoogleChart_Googleometer extends GoogleChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_Googleometer)->data($data)->size($size);
	}
}

class GoogleChart_QRCode extends GoogleChart {
	public function __construct($data=null, $size=null) {
		$this->type(parent::Type_QRCode)->data($data)->size($size);
	}
}

class GoogleChart_Tester extends GoogleChart {
	public static function Create($type=null, $data=null, $size=null) {
		return new GoogleChart($type, $data, $size);
	}
}
