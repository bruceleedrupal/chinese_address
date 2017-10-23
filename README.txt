此模块主要是实现中国地址的省市区三级联动,是china address field(https://www.drupal.org/project/china_address_field) 的升级版本,该模块提升了以下几项主要功能:
1.增加了新的form element 中国区地址类型，使用方法如下所示
$form['name'] = array(
		'#type' => 'chinese_address',
		'#title' => t('Name'),//标题
       		"#has_detail"=>1,//是否的详细门牌地址
        	"#default_value" => array(//默认地址
		    "province" => 33,
		    'city' => 3307,
		    'county' => 330702,
		    'street' => 330702008,
		    'detail' => ''
       		 ),

);

2.field 提供了多项输入的功能,不只是只能选一个地址输入,在输入过程中同时提供删除按钮


3.扩展了field views的条件筛选,提供了省份选择筛选列表

