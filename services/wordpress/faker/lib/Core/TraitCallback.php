<?php

trait TraitCallback
{
	protected $callbacks = [];

	/**
	 * コールバックを一括定義
	 */
	public function defineCallbacks($callbacks)
	{
		$this->callbacks = array_merge($this->callbacks, $callbacks);
		return $this;
	}

	/**
	 * 個別コールバック設定
	 */
	public function setCallback($key, $callback)
	{
		$this->callbacks[$key] = $callback;
		return $this;
	}

	/**
	 * コールバック実行（引数・戻り値対応）
	 */
	protected function callCallback($key, ...$args)
	{
		if (isset($this->callbacks[$key]) && is_callable($this->callbacks[$key])) {
			return call_user_func($this->callbacks[$key], ...$args);
		}
		return null;
	}

	/**
	 * コールバックが存在するかチェック
	 */
	protected function hasCallback($key)
	{
		return isset($this->callbacks[$key]) && is_callable($this->callbacks[$key]);
	}
}