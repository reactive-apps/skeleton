all:
	composer run-script qa --timeout=0

extended:
	composer run-script extended --timeout=0

contrib:
	composer run-script qa-contrib --timeout=0

init:
	composer ensure-installed

cs:
	composer cs

cs-fix:
	composer cs-fix

infection:
	composer run-script infection --timeout=0

unit:
	composer run-script unit --timeout=0

unit-coverage:
	composer run-script unit-coverage --timeout=0

smoke:
	composer run-script smoke --timeout=0

ci-coverage: init
	composer ci-coverage
