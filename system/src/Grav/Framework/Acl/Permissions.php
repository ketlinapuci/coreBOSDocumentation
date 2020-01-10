<?php

/**
 * @package    Grav\Framework\Acl
 *
 * @copyright  Copyright (C) 2015 - 2020 Trilby Media, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav\Framework\Acl;

class Permissions implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /** @var Action[] */
    protected $instances = [];
    /** @var Action[] */
    protected $actions = [];

    /**
     * @return array
     */
    public function getInstances(): array
    {
        return $this->instances;
    }

    /**
     * @param string $name
     * @return Action|null
     */
    public function getAction(string $name): ?Action
    {
        return $this->instances[$name] ?? null;
    }

    /**
     * @param Action $action
     */
    public function addAction(Action $action): void
    {
        $name = $action->name;
        $parent = $this->getParent($name);
        if ($parent) {
            $parent->addChild($action);
        } else {
            $this->actions[$name] = $action;
        }

        $this->instances[$name] = $action;

        // If Action has children, add those, too.
        foreach ($action->getChildren() as $child) {
            $this->instances[$child->name] = $child;
        }
    }

    /**
     * @return array
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param Action[] $actions
     */
    public function addActions(array $actions): void
    {
        foreach ($actions as $action) {
            $this->addAction($action);
        }
    }

    /**
     * @param array $access
     * @return Access
     */
    public function getAccess(array $access): Access
    {
        return new Access($access);
    }

    /**
     * @param int|string $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->nested[$offset]);
    }

    /**
     * @param int|string $offset
     * @return Action|null
     */
    public function offsetGet($offset): ?Action
    {
        return $this->nested[$offset] ?? null;
    }

    /**
     * @param int|string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new \RuntimeException(__METHOD__ . '(): Not Supported');
    }

    /**
     * @param int|string $offset
     */
    public function offsetUnset($offset): void
    {
        throw new \RuntimeException(__METHOD__ . '(): Not Supported');
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->actions);
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->actions);
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'actions' => $this->actions
        ];
    }

    /**
     * @param string $name
     * @return Action|null
     */
    protected function getParent(string $name): ?Action
    {
        if ($pos = strrpos($name, '.')) {
            $name = substr($name, 0, $pos);

            $parent = $this->getAction($name);
            if (!$parent) {
                // TODO: create parent action(s) on the fly
                throw new \RuntimeException(__METHOD__ . '(): Adding child action before parent is not supported');
            }

            return $parent;
        }

        return null;
    }
}