<?php
	// _plgContentAllWeblinksReplace will set the values;
	protected $new_window;
		
		$replace = "";
		// for every article we work
				if ($this->nofollow) {$nofollow=" rel=\"nofollow\" "; } else {$nofollow="";};
				$link = "<a class=\"link".$this->moduleclass_sfx."\" ".$target.$nofollow." title=\"".$title."\" href=\"".$URL."\">".strip_tags($dbarticle->title)."</a>";