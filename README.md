# Ajax IM 3.41

## What is Ajax IM 3.41?

Ajax IM ("Asynchronous Javascript And Xml Instant Messenger") is a browser-based
instant messaging client. It uses the XMLHTTPRequest object in JavaScript to send
and receive commands to and from the server. No refreshing of the page is ever
needed for this "web application" to work, as everything is updated in real-time
via JavaScript.

Ajax IM 3.41 is based on client-side JavaScript and PHP.  Ajax IM 4.0 is a "from
the ground up" rewrite that uses client-side JavaScript and Node.js (server-side
JavaScript).  Ajax IM 4.0 does not use PHP now.

Ajax IM 3.41 is made available here because there is still interest in this older
code and it is the basis for some code forks (e.g. ajaximrpg).  It is useful for
reference.

## Installation

1. Create a MySQL database

2. Configure SQL information in config-sample.php

3. Rename config-sample.php to config.php

4. Configure options in config.js (in the 'js' folder)

5. Upload all files to your server.

6. CHMOD buddyicons/ to 0777.

7. Run install.php in your browser of choice and follow the instructions.

8. Delete install.php and update.php!

9. Done!

## License

Copyright (c) 2009, Joshua Gross
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
* Neither the name of the Ajax IM nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.