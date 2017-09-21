此模块主要是实现中国地址的省市区三级联动,是china address field(https://www.drupal.org/project/china_address_field) 的升级版本,该模块提升了以下几项主要功能:
1.增加了新的form element 中国区地址类型，使用方法如下所示
$form['name'] = array(
		'#type' => 'chinese_address',
		'#title' => t('Name'),//标题
       		"#has_detail"=>1,//是否的详细门牌地址
        	"#default_value" => array(//默认地址
		    "province" => 31,
		    'city' => 386,
		    'county' => 3255,
		    'detail' => ''
       		 ),

);

2.field 提供了多项输入的功能,不只是只能选一个地址输入,在输入过程中同时提供删除按钮


3.扩展了field views的条件筛选,提供了省份选择筛选列表

模块信赖：
multiple_fields_remove_button （(https://www.drupal.org/project/multiple_fields_remove_button  解决多个输入时数量不断自动增加的问题,如果想默认输入数量正确,可先在网站根目录上应用multiform.patch,修复核心的建议输入数量,将得到最完美的输入效果）
