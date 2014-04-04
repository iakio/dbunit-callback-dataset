dbunit-callback-dataset
=======================

usage:

```
use iakio\dataset\CallbackDataSet;

class GuestBookTest extends \PHPUnit_Extensions_Database_TestCase
{
...
    function guestbook()
    {
        return array(
            array('id' => 1, 'content' => 'Hello buddy!', 'user' => 'joe', 'created' => '2010-04-24 17:15:23'),
            array('id' => 2, 'content' => 'I like it!',   'user' => null,  'created' => '2010-04-26 12:14:20'),
        );
    }

    function getDataSet()
    {
        return new CallbackDataSet($this, array('guestbook'));
    }
}
```


```
use iakio\dataset\CallbackDataSet;

class GuestBookTest extends \PHPUnit_Extensions_Database_TestCase
{
...
    function guestbook()
    {
        foreach (range(1, 10) as $i) {
            yield [
                'id' => $i,
                'content' => 'Hello buddy',
                'user' => "user_$i",
                'created' => '2010-04-24 17:15:23'
            ];
        }
    }
```
