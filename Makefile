.PHONY: tests
tests:
	@./vendor/bin/phpunit

benchmark:
	@./vendor/bin/phpbench run --report=aggregate --precision=3

benchmark-profile:
	@./vendor/bin/phpbench xdebug:profile --revs=1 --progress=none

benchmark-csv:
	@./vendor/bin/phpbench run --report=aggregate --precision=3 --output=csv