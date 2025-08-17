<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
	private array $routes = [];

	public function get(string $path, callable|array $handler): void { $this->map('GET', $path, $handler); }
	public function post(string $path, callable|array $handler): void { $this->map('POST', $path, $handler); }
	public function put(string $path, callable|array $handler): void { $this->map('PUT', $path, $handler); }
	public function delete(string $path, callable|array $handler): void { $this->map('DELETE', $path, $handler); }

	private function map(string $method, string $path, callable|array $handler): void
	{
		$this->routes[$method][] = $this->compile($path, $handler);
	}

	private function compile(string $path, callable|array $handler): array
	{
		$paramNames = [];
		$regex = preg_replace_callback('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', function ($m) use (&$paramNames) {
			$paramNames[] = $m[1];
			return '([^/]+)';
		}, rtrim($path, '/'));
		$regex = '#^' . ($regex === '' ? '/' : $regex) . '$#';
		return ['regex' => $regex, 'params' => $paramNames, 'handler' => $handler];
	}

	public function dispatch(string $method, string $path): void
	{
		$override = $_POST['_method'] ?? $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] ?? null;
		if ($override) { $method = strtoupper($override); }
		$path = '/' . trim(parse_url($path, PHP_URL_PATH) ?? '/', '/');
		foreach ($this->routes[$method] ?? [] as $route) {
			if (preg_match($route['regex'], rtrim($path, '/'), $m)) {
				array_shift($m);
				$params = [];
				foreach ($route['params'] as $i => $name) { $params[$name] = $m[$i] ?? null; }
				$handler = $route['handler'];
				if (is_array($handler)) {
					$controller = new $handler[0]();
					$action = $handler[1];
					$controller->$action($params);
					return;
				}
				call_user_func($handler, $params);
				return;
			}
		}
		http_response_code(404);
		echo '404 Not Found';
	}
}