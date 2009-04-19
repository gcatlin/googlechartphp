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

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../GoogleChart.php';

abstract class GoogleChart_TestCase extends PHPUnit_Framework_TestCase {

	public static function assertUrlQueryStringEquals($expected_query, $actual_url, $message='') {
		if (is_array($expected_query)) {
			$params = array();
			foreach ($expected_query as $key => $value) {
				$params[] = $key.'='.$value;
			}
			$expected_query = implode('&', $params);
		}
		$actual_query = parse_url($actual_url, PHP_URL_QUERY);
		return parent::assertEquals($expected_query, $actual_query, $message);
	}

	public static function assertUrlQueryStringContains($expected_params, $actual_url, $message='') {
		$actual_params = explode('&', parse_url($actual_url, PHP_URL_QUERY));
		$actual_matching_params = array();
		foreach ($actual_params as $param) {
			list($key, $value) = explode('=', $param);
			if (isset($expected_params[$key])) {
				$actual_matching_params[$key] = $value;
			}
		}
		return parent::assertEquals($expected_params, $actual_matching_params, $message);
	}

}

class GoogleChartTest extends GoogleChart_TestCase {

  /**
   * FactoryMethods()
   */
	public function test_Constructor_NoParametersPassed_Instantiates() {
		$chart = GoogleChart_Tester::Create();
		parent::assertTrue($chart instanceof GoogleChart);
	}
	
	public function test_LineChart_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_LineChart;
		$actual = GoogleChart::LineChart()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Sparkline_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_Sparkline;
		$actual = GoogleChart::Sparkline()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_BarChart_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_BarChart_VerticalGrouped;
		$actual = GoogleChart::BarChart()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_PieChart_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_PieChart;
		$actual = GoogleChart::PieChart()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_VennDiagram_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_VennDiagram;
		$actual = GoogleChart::VennDiagram()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_ScatterPlot_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_ScatterPlot;
		$actual = GoogleChart::ScatterPlot()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_RadarChart_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_RadarChart;
		$actual = GoogleChart::RadarChart()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Map_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_Map;
		$actual = GoogleChart::Map()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Googleometer_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_Googleometer;
		$actual = GoogleChart::Googleometer()->type; 
		parent::assertEquals($expected, $actual);
	}
	
	public function test_QRCode_NoParametersPassed_SetsProperType() {
		$expected = GoogleChart::Type_QRCode;
		$actual = GoogleChart::QRCode()->type; 
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * __get()
   */
	public function test_Get_ValidProperty_Returns() {
		$expected = GoogleChart::Type_LineChart;
		$actual = GoogleChart_Tester::Create($expected)->type;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Get_InvalidProperty_ReturnsNull() {
		$expected = null;
		$actual = GoogleChart_Tester::Create()->not_a_property;
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * __toString()
   */
	public function test_ToString_Called_ReturnsUrl() {
		$chart = GoogleChart_Tester::Create();
		$expected = $chart->url();
		$actual = (string) $chart;
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * colors()
   */
	public function test_Colors_PassedSingleValue_SetToValue() {
		$color = 'FF0000';
		$expected = array($color);
		$actual = GoogleChart_Tester::Create()->colors($color)->colors;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Colors_PassedMultipleValues_SetToValues() {
		$color1 = 'FF0000';
		$color2 = '00FF00';
		$color3 = '0000FF';
		$expected = array($color1, $color2, $color3);
		$actual = GoogleChart_Tester::Create()->colors($color1, $color2, $color3)->colors;
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * data()
   * @dataProvider provider_Data_ValidValues
   */
	public function test_Data_PassedValidValue_SetToValidValue($data, $expected) {
		$actual = GoogleChart_Tester::Create()->data($data)->data;
		parent::assertEquals($expected, $actual);
	}
	
	public function provider_Data_ValidValues() {
		return array(
			array(1, array(array(1))),
			array(array(1), array(array(1))),
			array(array(array(1)), array(array(1))),
		);
	}
	
	public function test_Data_PassedAsNull_SetToNull() {
		$data = null;
		$expected = $data;
		$actual = GoogleChart_Tester::Create()->data($data)->data;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Data_PassedAsNullAfterPreviouslySetToNonNull_SetToNull() {
		$data = 1;
		$expected = null;
		$actual = GoogleChart_Tester::Create()->data($data)->data(null)->data;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Data_PassedAsSeparateScalarElements_StoredAsArrayOfArrays() {
		$data1 = 1; $data2 = 2;
		$expected = array(array($data1, $data2));
		$actual = GoogleChart_Tester::Create()->data($data1, $data2)->data;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Data_PassedAsSeparateArrayElements_StoredAsArrayOfArrays() {
		$data1 = array(1); $data2 = array(2);
		$expected = array($data1, $data2);
		$actual = GoogleChart_Tester::Create()->data($data1, $data2)->data;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Data_PassedAsArray_StoredAsArrayOfArrays() {
		$data = array(1, 2);
		$expected = array($data);
		$actual = GoogleChart_Tester::Create()->data($data)->data;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Data_PassedAsArrayOfArrays_StoredAsArrayOfArrays() {
		$data = array(array(1, 2), array(3, 4));
		$expected = $data;
		$actual = GoogleChart_Tester::Create()->data($data)->data;
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * encoding()
   * @dataProvider provider_Encoding_ValidValues
   */
	public function test_Encoding_PassedValue_SetsValue($encoding) {
		$expected = $encoding;
		$actual = GoogleChart_Tester::Create()->encoding($encoding)->encoding;
		parent::assertEquals($expected, $actual);
	}
	
	public function provider_Encoding_ValidValues() {
		return array(
			array(null),
			array(GoogleChart::Encoding_Simple),
			array(GoogleChart::Encoding_Extended),
			array(GoogleChart::Encoding_Text),
		);
	}
	
  /**
   * param()
   */
	public function test_Param_PassedValue_SetsValue() {
		$name1 = GoogleChart::Param_Type;
		$value1 = 'lc';
		$name2 = GoogleChart::Param_Size;
		$value2 = 1;
		$expected = array($name1 => $value1, $name2 => $value2);
		$actual = GoogleChart_Tester::Create()->param($name1, $value1)->param($name2, $value2)->params;
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * size()
   */
	public function test_Size_PassedAsNull_SetToNull() {
		$size = null;
		$expected = null;
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_PassedAsNullAfterPreviouslySetToNonNull_SetToNull() {
		$size = 1;
		$expected = null;
		$actual = GoogleChart_Tester::Create()->size($size)->size(null)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_PassedAsSeparateElements_StoredAsArray() {
		$size = array(250, 100);
		list($width, $height) = $size;
		$expected = $size;
		$actual = GoogleChart_Tester::Create()->size($width, $height)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_PassedAsArray_StoredAsArray() {
		$size = array(250, 100);
		$expected = $size;
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_PassedWithoutHeight_HeightSetToWidth() {
		$size = 250;
		$expected = array(250, 250);
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_NonIntegerWidthOrHeight_ConvertedToInteger() {
		$size = (array(null, null));
		$expected = array(1, 1);
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_NonPositiveWidthAndHeight_SetToOne() {
		$size = array(-PHP_INT_MAX, -PHP_INT_MAX);
		$expected = array(1, 1);
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_NonPositiveWidthOrHeight_SetToOppositeValue() {
		$size = array(-PHP_INT_MAX, 2);
		$expected = array(2, 2);
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_ExceedsMaxWidth_SizeScaledProportionally() {
		$size = array(GoogleChart::Max_Width * 2, 1);
		$expected = array(GoogleChart::Max_Width, 1);
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_ExceedsMaxHeight_SizeScaledProportionally() {
		$size = array(1, GoogleChart::Max_Height * 2);
		$expected = array(1, GoogleChart::Max_Height);
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_ExceedsMaxArea_SizeScaledProportionally() {
		$size = array(GoogleChart::Max_Area, GoogleChart::Max_Area);
		$width = $height = floor(sqrt(GoogleChart::Max_Area)); 
		$expected = array($width, $height);
		$actual = GoogleChart_Tester::Create()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * title()
   * @dataProvider provider_Title_PassedAnyValue_SetToValue
   */
	public function test_Title_PassedAsNonNullValue_SetToNonNullValue($title) {
		$expected = $title;
		$actual = GoogleChart_Tester::Create()->title($title)->title;
		parent::assertEquals($expected, $actual);
	}
	
	public function provider_Title_PassedAnyValue_SetToValue() {
		return array(
			array(null),
			array('Title'),
		);
	}
	
  /**
   * url()
   */
	public function test_Url_NoInputsSpecified_ReturnsValidBaseUrl() {
		$expected = GoogleChart::Url;
		list($actual) = explode('?', GoogleChart_Tester::Create()->url());
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Url_NoInputsSpecified_QueryStringContainsOnlyDefaultSize() {
		$expected = array(GoogleChart::Param_Size => GoogleChart::Default_Width.'x'.GoogleChart::Default_Height);
		$actual = GoogleChart_Tester::Create()->url();
		parent::assertUrlQueryStringEquals($expected, $actual);
	}
	
	public function test_Url_OnlySizeSpecified_QueryStringContainsOnlySize() {
		$size = 1;
		$expected = array(GoogleChart::Param_Size => $size);
		$actual = GoogleChart_Tester::Create()->size($size)->url();
		parent::assertUrlQueryStringEquals($expected, $actual);
	}
	
	public function test_Url_TypeSpecified_QueryStringContainsType() {
		$type = GoogleChart::Type_LineChart;
		$expected = array(GoogleChart::Param_Type => $type);
		$actual = GoogleChart_Tester::Create($type)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
	public function test_Url_TitleSpecified_QueryStringContainsTitle() {
		$title = 'Title';
		$expected = array(GoogleChart::Param_Title => $title);
		$actual = GoogleChart_Tester::Create()->title($title)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
	public function test_Url_TitleAndTitleStyleSpecified_QueryStringContainsTitleAndTitleStyle() {
		$title = 'Title';
		$color = 'FF0000';
		$size = 16;		
		$expected = array(
			GoogleChart::Param_Title => $title,
			GoogleChart::Param_TitleStyle => $color.','.$size,
		);
		$actual = GoogleChart_Tester::Create()->title($title, $color, $size)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
	public function test_Url_TitleContainsAllowedUrlChars_CharsAreNotUrlEncoded() {
		$title = '|:,';
		$expected = array(GoogleChart::Param_Title => $title);
		$actual = GoogleChart_Tester::Create()->title($title)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
	public function test_Url_TitleContainsIllegalUrlChars_CharsAreUrlencoded() {
		$title = '!"#$%&';
		$expected = array(GoogleChart::Param_Title => '%21%22%23%24%25%26');
		$actual = GoogleChart_Tester::Create()->title($title)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
	public function test_Url_EncodingNotSpecified_DataEncodingDefaultsToSimpleEncodingMethod() {
		$data = array(0, 1);
		$expected = array(GoogleChart::Param_Data => 's:A9');
		$actual = GoogleChart_Tester::Create()->data($data)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
  /**
   * @dataProvider provider_Url_Encode_QueryStringContainsEncodedData
   */
	public function test_Url_EncodeSimple_QueryStringContainsEncodedData($data, $simple, $extended, $text) {
		$encoding = GoogleChart::Encoding_Simple;
		$expected = array(GoogleChart::Param_Data => $encoding.':'.$simple);
		$actual = GoogleChart_Tester::Create()->data($data)->encoding($encoding)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
  /**
   * @dataProvider provider_Url_Encode_QueryStringContainsEncodedData
   */
	public function test_Url_EncodeExtended_QueryStringContainsEncodedData($data, $simple, $extended, $text) {
		$encoding = GoogleChart::Encoding_Extended;
		$expected = array(GoogleChart::Param_Data => $encoding.':'.$extended);
		$actual = GoogleChart_Tester::Create()->data($data)->encoding($encoding)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
  /**
   * @dataProvider provider_Url_Encode_QueryStringContainsEncodedData
   */
	public function test_Url_EncodeText_QueryStringContainsEncodedData($data, $simple, $extended, $text) {
		$encoding = GoogleChart::Encoding_Text;
		$expected = array(GoogleChart::Param_Data => $encoding.':'.$text);
		$actual = GoogleChart_Tester::Create()->data($data)->encoding($encoding)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
	public function provider_Url_Encode_QueryStringContainsEncodedData() {
		return array(
			array(0, 'A', 'AA', '0'),
			array(array(null), '_', '__', '-1'),
			array(array(null, 0), '_A', '__AA', '-1,0'),
			array(array(0, null), 'A_', 'AA__', '0,-1'),
			array(array(-1), 'A', 'AA', '0'),
			array(array(0), 'A', 'AA', '0'),
			array(array(1), 'A', 'AA', '0'),
			array(array(0, 1), 'A9', 'AA..', '0,100'),
			array(array(1, 0), '9A', '..AA', '100,0'),
			array(array(-1, 0), 'A9', 'AA..', '0,100'),
			array(array(0, -1), '9A', '..AA', '100,0'),
			array(array(-1, 1), 'A9', 'AA..', '0,100'),
			array(array(1, -1), '9A', '..AA', '100,0'),
			array(array(1, 2), 'A9', 'AA..', '0,100'),
			array(array(2, 1), '9A', '..AA', '100,0'),
			array(array(-2, -1), 'A9', 'AA..', '0,100'),
			array(array(-1, -2), '9A', '..AA', '100,0'),
			array(array(-1, 0, 1), 'Af9', 'AAgA..', '0,50,100'),
			array(array(0, 1, 2), 'Af9', 'AAgA..', '0,50,100'),
			array(array(0, 1, 3), 'AU9', 'AAVV..', '0,33.3,100'),
			array(array(-PHP_INT_MAX), 'A', 'AA', '0'),
			array(array(PHP_INT_MAX), 'A', 'AA', '0'),
			array(array(-PHP_INT_MAX, PHP_INT_MAX), 'A9', 'AA..', '0,100'),
			array(array(PHP_INT_MAX, -PHP_INT_MAX), '9A', '..AA', '100,0'),
			array(array(array(0), array(0)), 'A,A', 'AA,AA', '0|0'),
			array(array(array(0,1), array(1,0)), 'A9,9A', 'AA..,..AA', '0,100|100,0'),
		);
	}
	
	public function test_Url_ColorSpecifiedDataNotSpecified_QueryStringDoesNotContainColors() {
		$color = 'FF0000';
		$expected = array(GoogleChart::Param_Color);
		$actual = GoogleChart_Tester::Create()->colors($color)->url();
		parent::assertTrue(strpos($actual, '&'.GoogleChart::Param_Color.'=') === false);
	}
	
	public function test_Url_ColorsAndDataSpecified_QueryStringContainsColors() {
		$color1 = 'FF0000';
		$color2 = '00FF00';
		$data = array(array(1), array(2));
		$expected = array(GoogleChart::Param_Color => $color1.','.$color2);
		$actual = GoogleChart_Tester::Create()->data($data)->colors($color1, $color2)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
	public function test_Url_TwoColorsAndOneDataSetSpecified_QueryStringContainsOneColor() {
		$color1 = 'FF0000';
		$color2 = '00FF00';
		$data = array(array(1));
		$expected = array(GoogleChart::Param_Color => $color1);
		$actual = GoogleChart_Tester::Create()->data($data)->colors($color1, $color2)->url();
		parent::assertUrlQueryStringContains($expected, $actual);
	}
	
}

class GoogleChart_MapTest extends GoogleChart_TestCase {

  /**
   * __get()
   */
	public function test_Get_ValidProperty_Returns() {
		$area = GoogleChart_Map::Area_World;
		$expected = $area;
		$actual = GoogleChart::Map()->area($area)->area;
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * area()
   * @dataProvider provider_Area_ValidValues
   */
	public function test_Area_PassedValidValue_SetToValidValue($area) {
		$expected = $area;
		$actual = GoogleChart::Map()->area($area)->area;
		parent::assertEquals($expected, $actual);
	}
	
	public function provider_Area_ValidValues() {
		return array(
			array(GoogleChart_Map::Area_Africa),
			array(GoogleChart_Map::Area_Asia),
			array(GoogleChart_Map::Area_Europe),
			array(GoogleChart_Map::Area_MiddleEast),
			array(GoogleChart_Map::Area_SouthAmerica),
			array(GoogleChart_Map::Area_USA),
			array(GoogleChart_Map::Area_World),
		);
	}
	
	public function test_Area_PassedAsNull_SetToNull() {
		$area = null;
		$expected = $area;
		$actual = GoogleChart::Map()->area($area)->area;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Area_PassedNullAfterPreviouslySetToNonNullValue_SetToNull() {
		$area = GoogleChart_Map::Area_World;
		$expected = null;
		$actual = GoogleChart::Map()->area($area)->area(null)->area;
		parent::assertEquals($expected, $actual);
	}
	
  /**
   * size()
   */
	public function test_Size_ExceedsMaxWidth_SizeScaledProportionally() {
		$size = array(GoogleChart_Map::Max_Width * 2, 1);
		$expected = array(GoogleChart_Map::Max_Width, 1);
		$actual = GoogleChart::Map()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}
	
	public function test_Size_ExceedsMaxHeight_SizeScaledProportionally() {
		$size = array(1, GoogleChart_Map::Max_Height * 2);
		$expected = array(1, GoogleChart_Map::Max_Height);
		$actual = GoogleChart::Map()->size($size)->size;
		parent::assertEquals($expected, $actual);
	}

}
