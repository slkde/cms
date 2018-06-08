<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Cache;

class DashboardController extends Controller
{
    //
    
    public function sitemap(Request $request)
	{
	   $date = @date("Y-m-d");
	   $xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	   $xml .= "<urlset>\n";
       $xml .= "<url><loc>http://www.ja168.net</loc><lastmod>$date</lastmod><changefreq>hourly</changefreq><priority>1.0</priority></url>\n";
       $rows = @DB::select("SELECT id FROM `categorys`");
       foreach($rows as $item)
       {
       	  $xml .= "<url><loc>http://www.ja168.net/category/{$item->id}</loc><lastmod>$date</lastmod><changefreq>hourly</changefreq><priority>0.8</priority></url>\n";
       }

       $rows = @DB::select("SELECT id FROM `articles` where `is_verify`='Y' AND YEAR(created_at) = YEAR(CURRENT_DATE) AND MONTH(created_at) = MONTH(CURRENT_DATE) order by id");
       foreach($rows as $item)
       {
       	  $xml .= "<url><loc>http://www.ja168.net/info-{$item->id}.html</loc><lastmod>$date</lastmod><changefreq>monthly</changefreq><priority>0.5</priority></url>\n";
       }
       $rows = @DB::select("SELECT id,post_title FROM `wp_posts` WHERE post_status=\"publish\" AND post_type=\"post\"");
       foreach($rows as $item)
       {
       	  $xml .= "<url><loc>http://www.ja168.net/blog/?p={$item->id}</loc><lastmod>$date</lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>\n";
       }

       //

	   $xml .= "</urlset>\n";
	   @file_put_contents(public_path() . '/sitemap.xml', $xml);
	   return 'ok';
    }
    
    public function clearlog()
	{
		@file_put_contents(storage_path() . '/logs/laravel.log', '');
		return 'ok';
    }
    
	public function clearcache()
	{
		Cache::flush();
		return 'ok';
	}
}
