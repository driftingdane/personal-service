<?php
/**
 * Created by PhpStorm.
 * User: wtrekker
 * Date: 18/08/2018
 * Time: 16:17
 */

function categorySubList($parent, $category, $data)
{

    //create a multidimensional array to hold a list of category and parent category

    $category = array(
        'categories' => array(),
        'parent_cats' => array()
    );

    //build the array lists with data from the category table
    foreach ($data['galleries'] as $nav_row) {

        $html = "";
        //creates entry into categories array with current category id ie. $categories['categories'][1]
        $category['categories'][$nav_row['menu_id']] = $nav_row->menu_id;
        //creates entry into parent_cats array. parent_cats array contains a list of all categories with children
        $category['parent_cats'][$nav_row['parent_id']][] = $nav_row['menu_id'];


    }

    if (isset($category['parent_cats'][$parent])) {

        $html .= "";

        foreach ($category['parent_cats'][$parent] as $cat_id) {

            $a = $category['categories'][$cat_id]['courses'];
            $icon = $category['categories'][$cat_id]['menu_icon'];
            $ct_desc = strlen($category['categories'][$cat_id]['menu_desc']);
            if ($ct_desc > 50) {
                $trailslash = "...";
            } else {
                $trailslash = "";
            }
            $title = strtolower(str_replace(" ", "-", $category['categories'][$cat_id]['menu_name']));
            $menu_name = trim($category['categories'][$cat_id]['menu_name']);


            if ($category['categories'][$cat_id]['parent_id'] != 0) {
                $html .= '<div class="lesson_categories main-margin">';
            } else {
                $html .= '<div id="lesson_categories" class="col-xs-12 col-sm-5 col-md-5 col-sm-offset-1 col-md-offset-1 main_margin">';
            }

            if (!isset($category['parent_cats'][$cat_id])) {
                if ($category['categories'][$cat_id]['parent_id'] == 0) {
                    $html .= '<div class="media-left"> 
                        <img alt="" width="200" height="auto" class="media-object img-circle svg" src=" ' . URLROOT . '/galleries/' . $icon . ' ">
                     </div>';
                }

                if ($category['categories'][$cat_id]['sort_order'] != 0) {
                    if ($category['categories'][$cat_id]['parent_id'] != 0) {
                        $html .= '<ul class="list-unstyled lead status-container"><li>
                       <a href=" ' . URLROOT . '/gallery/' . $category['categories'][$cat_id]['menu_id'] . '/' . $title . ' ">
                       
                        <i class=" fas fa-link strokegreenlight fa-fw" ></i> <span class="span_left status-label">(' . $a . ')</span>
                        <span class="status-text">' . $menu_name . '</span></a></li></ul>';

                    } else {

                        $html .= '<h2 class="media-heading heading_cat">
<a href=" ' . URLROOT . '/gallery/' . $category['categories'][$cat_id]['menu_id'] . '/' . $title . ' ">
<i class="fas fa-link fa-fw strokegreenlight"></i> <span class="span_left"> (' . $a . ')</span><span class="status-text">
' . $menu_name . '</span></a></h2>';
                    }

                }
            }

            if (isset($category['parent_cats'][$cat_id])) {

                if ($category['categories'][$cat_id]['sort_order'] != 0) {
                    $html .= '<div class="media-left"> 
                        <img alt="" width="200" height="auto" class="media-object img-circle svg" src="' . URLROOT . '/galleries/' . $icon . ' ">
                     </div><h2 class="media-heading heading_cat"><span class="status-text">'
                        . $menu_name . '</span></h2>';

                    $html .= categorySubList($cat_id, $category, $data);

                }

            }
            $html .= '  
            </div>';
        }

    }
    return $html;
}

// Function ends