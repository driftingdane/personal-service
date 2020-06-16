<?php
function makeMenu($items, $parentId)
{
$menu = array_filter($items, function ($item) use ($parentId) {
return $item['parent_id'] == $parentId;
});
foreach ($menu as &$item) {
$subItems = makeMenu($items, $item['id']);
if (!empty($subItems)) {
$item['sub_menu'] = $subItems;
}
}
return $menu;
}

//$readyMenu = makeMenu($itemsArray, 0);