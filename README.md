# pobox-regex
A better, simple PO Box Filter that is built around real-world address problems.

# The RegEx
````JavaScript
/(?:P(?:ost(?:al)?)?[\.\-\s]*(?:(?:O(?:ffice)?[\.\-\s]*)?B(?:ox|in|\b|\d)|o(?:ffice|\b|\.)(?:[-\s]*\d)|code)|box[-\s\b]*\d)/i
````

# Positive List
* PO 123
* P.O 123
* P.O. 123
* P. O. 123
* PO Box 123
* P O box 123
* P. O. Box 123
* P.O.Box 123
* post box 123
* post office box 123
* post office 123
* P.O.B 123
* P.O.B. 123
* Post Office Bin 123
* Postal Code 123
* Post Box #123
* Postal Box 123
* P.O. Box 123
* PO. Box 123
* P.o box 123
* Pobox 123
* pob 123
* pob123
* pobox123
* p.o. Box123
* po-box123
* p.o.-box 123
* PO-Box 123
* p-o-box 123
* p-o box 123
* box 123
* Box123
* Box-123

# Negative List
* 123 Box Turtle Circle, Sarasota, FL
* 123 Boxing Pass, San Antonio, TX
* 123 Poblano Lane, Edinburg, TX
* 123 P O Davis Drive, Auburn, AL
* 123 Postal Circle, Manitowish Waters, WI

# Verification with PHP
* Clone repo
* `composer install`
* `phpunit`

# Credits
Some inspiration from [Greg Ferrel](https://gist.github.com/gregferrell/7494667).

# Further Pointers
This project aims at a simple approach. You should look into address verification services If you need to identify bad street numbers, zip codes and other factors.
