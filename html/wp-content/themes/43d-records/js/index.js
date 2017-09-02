(function ($) {

  function Application() {
    this.init();
  }

  Application.prototype.init = function () {
    var self = this;

    this.$window = $(window);
    this.$bg = $('#bg');

    this.$main_menu = $('#main_menu');
    this.$social = $('#social');
    this.$ctrls = $('#ctrl_btns');
    this.fade_elements = [this.$main_menu, this.$social, this.$ctrls];

    this.$menu_menulist = $('#main_menu .menulist');
    this.$menu_menulist_open = false;
    this.$menu_infobox = $('#main_menu .infobox');
    this.$menu_infobox_open = false;
    this.$menu_timeline = $('#main_menu .timeline');
    this.$menu_timeline_open = false;

    this.$menulist = $('#menulist');
    this.$menulist_close_btn = $('#menulist .close_btn');

    this.$posts_list = $('#posts_list');
    this.$posts_list_navi = $('#posts_list_navi');
    this.$posts_list_navi_recent = $('#posts_list_navi .recent');
    this.$posts_list_navi_past = $('#posts_list_navi .past');

    this.$info_content = $('#info_content');
    this.$info_close_btn = $('#info_content .close_btn');
    this.$info_content_specs_mp3 = $('#info_content dl.specs.mp3');
    this.$info_content_specs_ogg = $('#info_content dl.specs.ogg');

    this.$timeline = $('#timeline');

    this.ARCHIVE_CATEGORY_NAME = php_vars.category_name;
    this.ARCHIVE_TAG = php_vars.tag;
    this.IS_ARCHIVE = php_vars.is_archive;

    this.SOUND_URL = {
      mp3: php_vars.recorded_sound_url_mp3,
      ogg: php_vars.recorded_sound_url_ogg
    };
    this.SOUND_LENGTH = php_vars.total_length;

    this.BG_IMAGE_ID = php_vars.cover_image_id;
    this.BG_URL = [
      [php_vars.cover_image_src_1440, 768],
      [php_vars.cover_image_src_2560, 1920],
      [php_vars.cover_image_src_3200, 2560],
      [php_vars.cover_image_src_4096, 3200],
      [php_vars.cover_image_src_5120, 9999]
    ];

    $('img', this.$bg).hide();

    this.BG_RESIZE_CHECK_TIME = 500;
    this.BG_RESIZE_CHECK_TIMER = -1;
    this.$window.resize(this.bgResizeProcess);

    this.FULL_VIEW_TIME = 4000;
    this.FULL_VIEW_TIMER = -1;

    if (this.IS_ARCHIVE == 'true') {
      this.$menulist.fadeTo(0, 1).hide();
      setTimeout(function () {
        self.$menu_menulist.addClass('active');
        self.$menulist.animate({width: 'toggle'}, 600, function () {
          $('.inner_container, .close_btn', self.$menulist).fadeTo(200, 1);
          self.$menu_menulist_open = true;
        });

        self.bgResizeProcess(0);
      }, 200);
    } else {
      this.$info_content.fadeTo(0, 1).hide();
      setTimeout(function () {
        self.$menu_infobox.addClass('active');
        self.$info_content.animate({width: 'toggle'}, 600, function () {
          $('.inner_container, .close_btn', self.$info_content).fadeTo(200, 1);
          self.$menu_infobox_open = true;
        });

        self.bgResizeProcess(0);
      }, 200);
    }

    //// event handlers

    this.$menu_menulist.click(function (e) {
      e.preventDefault();
      if (self.$menu_menulist_open) return;
      self.$menu_menulist.addClass('active');

      if (self.$menu_infobox_open) {
        $('.inner_container, .close_btn', self.$info_content).fadeTo(200, 0);
        self.$info_content.animate({width: 'toggle'}, 400, function () {
          self.$menu_infobox.removeClass('active');
          self.$menu_infobox_open = false;
        });
      }

      if (self.$menu_timeline_open) {
        self.$menu_timeline.removeClass('active');
        self.$menu_timeline_open = false;
        self.$timeline.fadeOut();
      }

      self.$menulist.animate({width: 'toggle'}, 600, function () {
        $('.inner_container, .close_btn', self.$menulist).fadeTo(200, 1);
        self.$menu_menulist_open = true;
      });
    });

    this.$menulist_close_btn.click(function (e) {
      e.preventDefault();
      if (!self.$menu_menulist_open) return;

      $('.inner_container, .close_btn', self.$menulist).fadeTo(200, 0);
      self.$menulist.animate({width: 'toggle'}, 600, function () {
        self.$menu_menulist.removeClass('active');
        self.$menu_menulist_open = false;
      });
    });

    this.$menu_infobox.click(function (e) {
      e.preventDefault();
      if (self.$menu_infobox_open) return;
      self.$menu_infobox.addClass('active');

      if (self.$menu_menulist_open) {
        $('.inner_container, .close_btn', self.$menulist).fadeTo(200, 0);
        self.$menulist.animate({width: 'toggle'}, 400, function () {
          self.$menu_menulist.removeClass('active');
          self.$menu_menulist_open = false;
        });
      }

      if (self.$menu_timeline_open) {
        self.$menu_timeline.removeClass('active');
        self.$menu_timeline_open = false;
        self.$timeline.fadeOut();
      }

      self.$info_content.animate({width: 'toggle'}, 600, function () {
        $('.inner_container, .close_btn', self.$info_content).fadeTo(200, 1);
        self.$menu_infobox_open = true;
      });
    });

    this.$info_close_btn.click(function (e) {
      e.preventDefault();
      if (!self.$menu_infobox_open) return;

      $('.inner_container, .close_btn', self.$info_content).fadeTo(200, 0);
      self.$info_content.animate({width: 'toggle'}, 400, function () {
        self.$menu_infobox.removeClass('active');
        self.$menu_infobox_open = false;
      });
    });

    this.$menu_timeline.click(function (e) {
      e.preventDefault();
      if (self.$menu_timeline_open) return;
      self.$menu_timeline.addClass('active');

      if (self.$menu_infobox_open) {
        $('.inner_container, .close_btn', self.$info_content).fadeTo(200, 0);
        self.$info_content.animate({width: 'toggle'}, 400, function () {
          self.$menu_infobox.removeClass('active');
          self.$menu_infobox_open = false;
        });
      }
      if (self.$menu_menulist_open) {
        $('.inner_container, .close_btn', self.$menulist).fadeTo(200, 0);
        self.$menulist.animate({width: 'toggle'}, 400, function () {
          self.$menu_menulist.removeClass('active');
          self.$menu_menulist_open = false;
        });
      }

      self.$timeline.fadeIn(function () {
        self.$menu_timeline_open = true;
      });
      SC.resizeProcess();
    });

    this.current_page = this.$posts_list_navi.data('page');
    this.last_page = this.$posts_list_navi.data('last');

    this.$posts_list_navi_recent.click(function (e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: php_vars.ajaxurl,
        data: {
          'action': 'post_list',
          'page': self.current_page - 1,
          'category_name': self.ARCHIVE_CATEGORY_NAME,
          'tag': self.ARCHIVE_TAG
        },
        success: function (res) {
          jsonData = JSON.parse(res);
          console.log(jsonData[1]);
          self.$posts_list.html(jsonData[3]);
          self.current_page = jsonData[1];
          set_posts_list_navi();
        }
      });
    });

    this.$posts_list_navi_past.click(function (e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: php_vars.ajaxurl,
        data: {
          'action': 'post_list',
          'page': self.current_page + 1,
          'category_name': self.ARCHIVE_CATEGORY_NAME,
          'tag': self.ARCHIVE_TAG
        },
        success: function (res) {
          jsonData = JSON.parse(res);
          console.log(jsonData[1]);
          self.$posts_list.html(jsonData[3]);
          self.current_page = jsonData[1];
          set_posts_list_navi();
        }
      });
    });

    function set_posts_list_navi() {
      if (self.current_page > 0) {
        self.$posts_list_navi_recent.removeClass('hidden');
      } else {
        self.$posts_list_navi_recent.addClass('hidden');
      }
      if (self.current_page < self.last_page) {
        self.$posts_list_navi_past.removeClass('hidden');
      } else {
        self.$posts_list_navi_past.addClass('hidden');
      }
    }


    this.$window.bind('touchstart touchmove', full_view_mode);
    this.$window.mousemove(full_view_mode);

    function full_view_mode(e) {
      clearTimeout(self.FULL_VIEW_TIMER);
      for (elm of self.fade_elements) {
        elm.fadeIn();
      }
      if (self.$menu_timeline_open) {
        self.$timeline.fadeIn();
      }
      SC.resizeProcess();

      self.FULL_VIEW_TIMER = setTimeout(function () {
        if (
          !self.$menu_menulist_open && !self.$menu_infobox_open
        ) {
          for (elm of
            self.fade_elements
            ) {
            elm.fadeOut();
          }
        }
        if (self.$menu_timeline_open) {
          self.$timeline.fadeOut();
        }
      }, self.FULL_VIEW_TIME);
    }
  };

  Application.prototype.bgResizeProcess = function (e) {
    var self = APP;

    if (self.BG_IMAGE_ID <= 0) return;
    clearTimeout(self.BG_RESIZE_CHECK_TIMER);

    var d_time = (typeof e === 'number') ? e : self.BG_RESIZE_CHECK_TIME;

    self.BG_RESIZE_CHECK_TIMER = setTimeout(function () {
      var bg_num = self.BG_URL.length, cw = self.$window.width();
      for (var i = 0; i < bg_num; i++) {
        if (cw <= self.BG_URL[i][1] && self.BG_URL[i][0].length > 0) {
          self.$bg.css('background-image', "url('" + self.BG_URL[i][0] + "')");
          break;
        }
      }
    }, d_time);
  };

  //////////////////

  function Soundscape() {
    if (APP.SOUND_URL['mp3'] == false && APP.SOUND_URL['ogg'] == false) {
      $('#main_menu li.timeline, #timeline').remove();
      return;
    }
    this.init();
  }

  Soundscape.prototype.init = function () {
    var self = this;

    this.context = false;
    this.audio = false;
    this.format = '';
    this.timeline_width = 0;
    this.timeline_interbal_id = -1;
    this.is_touch = ('ontouchstart' in window);

    this.$window = $(window);
    this.$play = $('#ctrl_btns .play');
    this.$pause = $('#ctrl_btns .pause');
    this.$timeline = $('#timeline');
    this.$current_time = $('#timeline .current_time');
    this.$cursor = $('#timeline .cursor');
    this.$horizontal_bar = $('#timeline .horizontal_bar');
    this.$back10s = $('#timeline .back10s');
    this.$rewind = $('#timeline .rewind');

    this.$play.hide();
    this.$pause.hide();

    this.$window.resize(this.resizeProcess);

    var at = new Audio();

    this.support_codecs = {
      mp3: !!at.canPlayType('audio/mpeg;').replace(/^no$/, ''),
      ogg: !!at.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, ''),
      wav: !!at.canPlayType('audio/wav; codecs="1"').replace(/^no$/, ''),
      m4a: !!(at.canPlayType('audio/x-m4a;') || at.canPlayType('audio/aac;')).replace(/^no$/, ''),
      webm: !!at.canPlayType('audio/webm; codecs="vorbis"').replace(/^no$/, '')
    };

    this.$window.load(function () {

      if (APP.SOUND_URL['mp3'].length == 0 && APP.SOUND_URL['ogg'].length == 0) {
        return;
      }

      try {
        window.AudioContext = window.AudioContext || window.webkitAudioContext;
        self.context = new AudioContext();
      } catch (e) {
        alert('Web Audio API is not supported in this browser.');
        return;
      }

      if (self.support_codecs.mp3 && APP.SOUND_URL['mp3'].length > 0) {
        self.format = 'mp3';
        if (APP.$info_content_specs_mp3) {
          APP.$info_content_specs_mp3.show();
        }
      } else if (self.support_codecs.ogg && APP.SOUND_URL['ogg'].length > 0) {
        self.format = 'ogg';
        if (APP.$info_content_specs_ogg) {
          APP.$info_content_specs_ogg.show();
        }
      }

      if (self.format.length == 0) {
        alert('The audio format of this content is not supported in this browser.');
        return;
      }

      self.audio = new Audio(APP.SOUND_URL[self.format]);
      self.audio.addEventListener('loadstart', function () {
        var source = self.context.createMediaElementSource(self.audio);
        source.connect(self.context.destination);
      }, false);

      self.$play.fadeIn();
    });

    this.$play.click(function (e) {
      self.audio.volume = 1;
      self.audio.loop = true;

      self.audio.play();

      self.$play.hide();
      self.$pause.fadeIn();

      clearInterval(self.timeline_interbal_id);
      self.timeline_interbal_id = setInterval(self.updateTime, 100);

      e.preventDefault();
    });

    this.$pause.click(function (e) {
      e.preventDefault();

      if (self.audio) {
        self.audio.pause();
      }

      self.$pause.hide();
      self.$play.fadeIn();

      clearInterval(self.timeline_interbal_id);
      self.timeline_interbal_id = -1;
    });

    this.$back10s.click(function (e) {
      e.preventDefault();

      if (self.audio) {
        self.audio.currentTime = Math.max(0, self.audio.currentTime - 10);
      }
      this.blur();
    });

    this.$rewind.click(function (e) {
      e.preventDefault();

      if (self.audio) {
        self.audio.currentTime = 0;
      }
      this.blur();
    });

    this.current_time = -1;
    this.cursor_mouse_x = -1;
    this.cursor_x = -1;
    this.new_time = -1;
    this.cursor_dragging = false;

    this.$cursor.mousedown(function (e) {
      e.preventDefault();

      self.cursor_dragging = true;
      self.current_time = 0;
      if (self.audio) {
        self.current_time = self.audio.currentTime;
      }

      self.cursor_x = parseFloat(self.$cursor.css('margin-left'));
      self.cursor_mouse_x = e.clientX;

      self.$window.bind('mousemove', self.handleCursor);
      self.$window.bind('mouseup', self.stopHandleCursor);
    });

    this.$cursor.bind('touchstart', function (e) {
      e.preventDefault();

      self.cursor_dragging = true;
      self.current_time = 0;
      if (self.audio) {
        self.current_time = self.audio.currentTime;
      }

      self.cursor_x = parseFloat(self.$cursor.css('margin-left'));
      self.cursor_mouse_x = e.originalEvent.targetTouches[0].pageX;

      self.$window.bind('mousemove touchmove', self.handleCursor);
      self.$window.bind('touchend', self.stopHandleCursor);
    });

  };

  Soundscape.prototype.handleCursor = function (e) {

    e.preventDefault();
    var self = SC;

    var seekLimit = self.audio ? Math.min(self.audio.seekable.end(0), APP.SOUND_LENGTH) : APP.SOUND_LENGTH;
    var current_mouse = (self.is_touch && e.originalEvent.targetTouches) ? e.originalEvent.targetTouches[0].pageX : e.clientX;
    var delta = (current_mouse - self.cursor_mouse_x) / self.timeline_width * APP.SOUND_LENGTH;
    self.new_time = Math.min(self.audio.seekable.end(0), Math.max(0, self.current_time + delta));

    var marginLeft = self.new_time / APP.SOUND_LENGTH * self.timeline_width;
    self.$cursor.css('margin-left', marginLeft);
  };

  Soundscape.prototype.stopHandleCursor = function (e) {
    e.preventDefault();
    var self = SC;

    self.$window.unbind('mousemove touchmove', self.handleCursor);
    self.$window.unbind('mouseup touchend', self.stopHandleCursor);

    if (self.cursor_dragging) {
      self.cursor_dragging = false;
    } else {
      return;
    }

    self.audio.currentTime = self.new_time;
  };

  Soundscape.prototype.resizeProcess = function () {
    var self = SC;
    if (self.$horizontal_bar == null) return;
    self.timeline_width = self.$horizontal_bar.width();
  };

  Soundscape.prototype.updateTime = function () {
    var self = SC;

    var marginLeft = self.audio.currentTime / APP.SOUND_LENGTH * self.timeline_width;
    if (!self.cursor_dragging) {
      self.$cursor.css('margin-left', marginLeft);
    }
    self.$current_time.text(convertTimeFormat(self.audio.currentTime));
  };

  var APP = new Application();
  var SC = new Soundscape();

  function convertTimeFormat(s) {
    s = Math.round(s);

    var sec = s % 60;
    if (sec < 10) {
      sec = '0' + sec;
    }
    return Math.floor(s / 60) + ':' + sec;
  }

})(jQuery);