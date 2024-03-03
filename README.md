# CAWebPublishing Development Toolbox
This plugin extends the [WordPress Rest API](https://developer.wordpress.org/rest-api/) and adds a powerful IDE built with [CodeMirror](https://codemirror.net/) to allow developers to quickly run PHP and SQL commands in realtime. 

## How to use this plugin
- Install and enable this plugin
- Keep the plugin up-to-date for important security updates.
- Check our CHANGELOG for notifications of major updates.

## Dependencies
- Requires WordPress 6.4 or greater.
- Requires PHP 8.1 or greater

## API Endpoints
`/wp-json/caweb/v1/sync` - Allows for updating taxonomy ID's.
  
Requst Example:  
{  
&nbsp;&nbsp;&nbsp;&nbsp;method: 'POST',  
&nbsp;&nbsp;&nbsp;&nbsp;url: 'http://example.com/wp-json/caweb/v1/sync',  
&nbsp;&nbsp;&nbsp;&nbsp;headers: {  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'Authorization': [Authentication Method](https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/),  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'content-type': 'multipart/form-data',  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'accept': '*/*',  
&nbsp;&nbsp;&nbsp;&nbsp;},  
&nbsp;&nbsp;&nbsp;&nbsp;data: {  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;id: 1,    
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;newId: 10,    
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tax: 'pages', // Allowed taxonomies include pages, posts, media, menus   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;locations: ['header-menu'], // This parameter is only used for menus and allows assigning a menu to a registered location.    
&nbsp;&nbsp;&nbsp;&nbsp;},  
}
                