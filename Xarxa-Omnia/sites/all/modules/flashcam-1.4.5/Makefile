FCAMVER=1.4.5
VLOOPDIR=vloopback
PREFIX=/usr/local/flashcam
BINDIR=/usr/local/bin
DISTDIR=flashcam-$(FCAMVER)
CFLAGS=-g

all: flashcamhook.so flashcam vloopback flashcamwrap fcinit

flashcamwrap: Makefile wrapper.in
	@echo Creating wrapper
	sed 's:%FCPATH%:$(PREFIX):' wrapper.in > $@
	chmod +x $@
	@echo Done.

fcinit: fcinit.in
	@echo Creating startup script
	sed 's:%BINDIR%:$(BINDIR):' fcinit.in > $@
	@echo Done.

flashcamhook.so: flashcamhook.c
	$(CC) $(CFLAGS) -shared -fPIC -o $@ flashcamhook.c

flashcam: flashcam.c
	$(CC) $(CFLAGS) -o $@ flashcam.c

vloopback: $(VLOOPDIR)/vloopback.ko

$(VLOOPDIR)/vloopback.ko:
	(cd $(VLOOPDIR); $(MAKE));

install: all
	install -d $(PREFIX)
	install -d $(PREFIX)/bin
	-ln -s $(BINDIR)/flashcamwrap $(PREFIX)/bin/firefox
	-ln -s $(BINDIR)/flashcamwrap $(PREFIX)/bin/flashplayer
	install -m 755 flashcamhook.so $(PREFIX)
	install -m 755 flashcam flashcamwrap $(BINDIR)
	install -m 755 fcinit /etc/init.d
	(cd $(VLOOPDIR); $(MAKE) $@);
	if [ -x /sbin/chkconfig ]; then chkconfig --add fcinit; fi
	if [ -x /usr/sbin/update-rc.d ]; then update-rc.d fcinit defaults; fi

uninstall:
	if [ -x /sbin/chkconfig ]; then chkconfig --del fcinit; fi
	if [ -x /usr/sbin/update-rc.d ]; then update-rc.d -f fcinit remove; fi
	rm -f $(BINDIR)/flashcam
	rm -f $(BINDIR)/flashcamwrap
	rm -rf $(PREFIX)/bin
	rm -f $(PREFIX)/flashcamhook.so
	rmdir $(PREFIX)
	rm -f /etc/init.d/fcinit
	(cd $(VLOOPDIR); $(MAKE) $@);

DISTFILES=$(DISTDIR)/Makefile\
	  $(DISTDIR)/LICENSES\
	  $(DISTDIR)/*.c\
	  $(DISTDIR)/wrapper.in\
	  $(DISTDIR)/fcinit.in\
	  $(DISTDIR)/Test\
	  $(DISTDIR)/$(VLOOPDIR)

dist: clean exclude.lst
	tar czvfh $(DISTDIR).tgz -X exclude.lst $(DISTFILES)
	rm -f $(DISTDIR)
	rm -rf exclude.lst

$(DISTDIR):
	ln -sf . $(DISTDIR)

exclude.lst: $(DISTDIR)
	find $(DISTDIR)/ -name CVS > $@

clean:
	rm -f flashcamhook.so flashcam flashcamwrap
	(cd $(VLOOPDIR); $(MAKE) $@);
	rm -f $(DISTDIR).tgz
	rm -f fcinit
