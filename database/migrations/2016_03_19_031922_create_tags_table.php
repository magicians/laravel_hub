<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag_name')->unique();
            $table->string('tag_group');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('tags')->insert(
            [
                [

                    'tag_name' => '问与答',
                    'tag_group' => '分享与探索',
                ],
                [
                    'tag_name' => '分享发现',
                    'tag_group' => '分享与探索',
                ],
                [
                    'tag_name' => '分享创造',
                    'tag_group' => '分享与探索',
                ],
                [
                    'tag_name' => '分享邀请码',
                    'tag_group' => '分享与探索',
                ],
                [
                    'tag_name' => '自言自语',
                    'tag_group' => '分享与探索',
                ],
                [
                    'tag_name' => '奇思妙想',
                    'tag_group' => '分享与探索',
                ],
                [
                    'tag_name' => '随想',
                    'tag_group' => '分享与探索',
                ],
                [
                    'tag_name' => '开源项目',
                    'tag_group' => '分享与探索',
                ],

                [
                    'tag_name' => '社区',
                    'tag_group' => '生活',
                ],
	            [
		            'tag_name' => '二手交易',
		            'tag_group' => '生活',
	            ],

	            [
		            'tag_name' => '房产',
		            'tag_group' => '生活',
	            ],
	            [
		            'tag_name' => '广告',
		            'tag_group' => '生活',
	            ],
	            [
		            'tag_name' => '汽车',
		            'tag_group' => '生活',
	            ],
	            [
		            'tag_name' => '家居',
		            'tag_group' => '生活',
	            ],

                [
                    'tag_name' => '企业招聘',
                    'tag_group' => '招聘',
                ],
                [
                    'tag_name' => '公司招聘',
                    'tag_group' => '招聘',
                ],
                [
                    'tag_name' => '全职',
                    'tag_group' => '招聘',
                ],
                [
                    'tag_name' => '兼职',
                    'tag_group' => '招聘',
                ],
	            //生活社区导航
                [
                    'tag_name' => 'iPhone',
                    'tag_group' => 'apple',
                ],
                [
                    'tag_name' => 'iPad',
                    'tag_group' => 'apple',
                ],

	            [
		            'tag_name' => 'iMac',
		            'tag_group' => 'apple',
	            ],

	            [
		            'tag_name' => 'MacBook',
		            'tag_group' => 'apple',
	            ],
	            //生活社区导航结束
                [
                    'tag_name' => '健康',
                    'tag_group' => '分享',
                ],
                [
                    'tag_name' => '工具',
                    'tag_group' => '分享',
                ],
                [
                    'tag_name' => '其他',
                    'tag_group' => '分享',
                ],
                [
                    'tag_name' => '书籍',
                    'tag_group' => '分享',
                ],
                [
                    'tag_name' => '创业',
                    'tag_group' => '分享',
                ],

	            [
		            'tag_name' => 'UNIQLQ',
		            'tag_group' => '品牌',
	            ],
	            [
		            'tag_name' => 'GOOC',
		            'tag_group' => '品牌',
	            ],

	            [
		            'tag_name' => '大众',
		            'tag_group' => '汽车',
	            ],
	            [
		            'tag_name' => '奥迪',
		            'tag_group' => '汽车',
	            ],
	            [
		            'tag_name' => '奔驰',
		            'tag_group' => '汽车',
	            ],
	            [
		            'tag_name' => '通用',
		            'tag_group' => '汽车',
	            ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tags');
    }
}
