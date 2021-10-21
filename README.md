## Critical css generation by sources
[![License](https://img.shields.io/badge/License-BSD%203--Clause-blue.svg?style=for-the-badge)](https://opensource.org/licenses/BSD-3-Clause)
======
A module that handles the critical css generation from less sources.
___
### The elephant in the room
If you want to serve critical css as less sources, of course, you can put your critical.less in your custom theme directory.
```shell script
app/design/frontend/[Vendor]/[Custom-Theme]/web/css/critical.less
```
And then, in the static:content:deploy phase, the critical.css file will be generated and saved in the static content folder.
However, even in production mode, Magento will always try to fetch that file from the source directory, 
so it will re-build critical.css on each request.

### Solution
This module simply replaces Magento's original ViewModel that reads the critical.css content, to fetch it from the static content folder instead.

*Happy Coding*