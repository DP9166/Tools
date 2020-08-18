<?php

/* 链表
    1. 单链表
        头节点:    记录链表都基地址
        尾节点:    指向空地址null
    2. 循环链表
    3. 双向链表
        除了有一个指向下一节点的指针外, 还有一个用于指向上一个节点的指针
        因为在删除的时候, 需要将其前驱节点都指针指向被删除节点都下一个节点，这样我们就要获取前驱节点, 在单链表中获取前驱节点都时间复杂度是O(n)
    4. 双向循环链表
        将双向链表都首尾通过指针连接起来
*/

class LinkedList
{
    private $list = [];

    public function get($index)
    {
        $value = NULL;

        while (current($this->list)) {
            if (key($this->list) == $index) {
                $value = current($this->list);
            }
            next($this->list);
        }

        reset($this->list);
        return $value;
    }

    public function add($value, $index = 0)
    {
        array_splice($this->list, $index, 0, $value);
    }

    public function remove($index)
    {
        array_splice($this->list, $index, 1);
    }

    public function isEmpty()
    {
        return !next($this->list);
    }

    public function size()
    {
        return count($this->list);
    }
}

$linkedList = new LinkedList();
$linkedList->add(4);
$linkedList->add(5);
$linkedList->add(3);
print $linkedList->get(1);   # 输出5
$linkedList->add(1, 1);      # 在结点1的位置上插入1
print $linkedList->get(1);   # 输出1
$linkedList->remove(1);      # 移除结点1上的元素
print $linkedList->get(1);   # 输出5
print $linkedList->size();   # 输出3