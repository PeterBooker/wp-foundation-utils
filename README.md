# WordPress Foundation Utils

A collection of functions and classes to make using Foundation for Sites with WordPress a little easier.

This is designed so that you can use the entire repo as a standard Plugin, each file inside a folder as an MU (Must Use) Plugin or simply copy the code. Whatever is right for you.

## Menus

All menu's require you to pass args containing one of `menu` or `theme-location` so that it knows which menu to display.

Basic Menu:
```php
wpfu_menu( array(
    'theme_location' => 'main-menu'
) );
```

Top Bar Menu:
```php
wpfu_top_bar_menu(
    'top-bar-menu', // ID
    array( 'theme_location' => 'top-bar-left' ), // Left Side
	array( 'theme_location' => 'top-bar-right' ), // Right Side
);
```

Responsive Menu:
```php
wpfu_responsive_menu(
	'Testing', // Title Text
	'top-bar-menu', // ID
	array( 'theme_location' => 'top-bar-left' ), // Left Side
	array( 'theme_location' => 'top-bar-right' ), // Right Side
);
```

## Pagination

```php
// Can provide args to adjust output if needed
wpfu_pagination();
```