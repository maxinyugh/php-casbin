<?php

namespace Casbin;

use Casbin\Exceptions\NotImplementedException;

/**
 * Trait InternalApi.
 *
 * @author techlee@qq.com
 */
trait InternalApi
{
    /**
     * adds a rule to the current policy.
     *
     * @param string $sec
     * @param string $ptype
     * @param array  $rule
     *
     * @return mixed
     */
    protected function addPolicyInternal($sec, $ptype, array $rule)
    {
        $ruleAdded = $this->model->addPolicy($sec, $ptype, $rule);
        if (!$ruleAdded) {
            return $ruleAdded;
        }

        if (!is_null($this->adapter) && $this->autoSave) {
            try {
                $this->adapter->addPolicy($sec, $ptype, $rule);
            } catch (NotImplementedException $e) { }

            if (!is_null($this->watcher)) {
                // error intentionally ignored
                $this->watcher->update();
            }
        }

        return $ruleAdded;
    }

    /**
     * removes a rule from the current policy.
     *
     * @param string $sec
     * @param string $ptype
     * @param array  $rule
     *
     * @return mixed
     */
    protected function removePolicyInternal($sec, $ptype, array $rule)
    {
        $ruleRemoved = $this->model->removePolicy($sec, $ptype, $rule);
        if (!$ruleRemoved) {
            return $ruleRemoved;
        }

        if (!is_null($this->adapter) && $this->autoSave) {
            try {
                $this->adapter->removePolicy($sec, $ptype, $rule);
            } catch (NotImplementedException $e) { }

            if (!is_null($this->watcher)) {
                // error intentionally ignored
                $this->watcher->update();
            }
        }

        return $ruleRemoved;
    }

    /**
     * adds a rule to the current policies.
     *
     * @param string $sec
     * @param string $ptype
     * @param array  $rules
     *
     * @return mixed
     */
    protected function addPoliciesInternal($sec, $ptype, array $rules)
    {
        foreach ($rules as $key => $value) {
            if (!$this->model->addPolicy($sec, $ptype, $value)) {
                unset($rules[$key]);
            };
        }

        if (!is_null($this->adapter) && $this->autoSave) {
            try {
                $this->adapter->addPolicies($sec, $ptype, $rules);
            } catch (NotImplementedException $e) { }
            if (!is_null($this->watcher)) {
                // error intentionally ignored
                $this->watcher->update();
            }
        }

        return true;
    }


    /**
     * removes rules based on field filters from the current policy.
     *
     * @param string $sec
     * @param string $ptype
     * @param int    $fieldIndex
     * @param mixed  ...$fieldValues
     *
     * @return bool
     */
    protected function removeFilteredPolicyInternal($sec, $ptype, $fieldIndex, ...$fieldValues)
    {
        $ruleRemoved = $this->model->removeFilteredPolicy($sec, $ptype, $fieldIndex, ...$fieldValues);
        if (!$ruleRemoved) {
            return $ruleRemoved;
        }

        if (!is_null($this->adapter) && $this->autoSave) {
            try {
                $this->adapter->removeFilteredPolicy($sec, $ptype, $fieldIndex, ...$fieldValues);
            } catch (NotImplementedException $e) { }

            if (!is_null($this->watcher)) {
                // error intentionally ignored
                $this->watcher->update();
            }
        }

        return $ruleRemoved;
    }


    /**
     * removes a rule from the current policys.
     *
     * @param string $sec
     * @param string $ptype
     * @param array  $rules
     *
     * @return mixed
     */
    protected function removePoliciesInternal(string $sec, string $ptype, array $rules)
    {
        if (!is_null($this->adapter) && $this->autoSave) {
            try {
                $this->adapter->removePolicies($sec, $ptype, $rules);
            } catch (NotImplementedException $e) { }

            if (!is_null($this->watcher)) {
                // error intentionally ignored
                $this->watcher->update();
            }
        }

        return true;
    }
}
