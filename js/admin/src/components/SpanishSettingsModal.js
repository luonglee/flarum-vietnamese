// Copyright © 2015 Toby Zerner and Flarum
// Copyright © 2015 Johann Rodríguez and Flarum en Español
// ---
// All rights reserved

import SettingsModal from 'flarum/components/SettingsModal';

export default class SpanishSettingsModal extends SettingsModal {
  className() {
    return 'SpanishSettingsModal Modal--small';
  }

  title() {
    return "Spanish";
  }

  form() {
    return [
      <div className="Form-group">
        <fieldset class="BasicsPage-homePage">
        <legend>Mode</legend>
        <label class="checkbox">
        <input type="radio" bidi={this.setting('flarumes-spanish.mode')} value="formal"/>
        Formal</label>
        <label class="checkbox">
        <input type="radio" bidi={this.setting('flarumes-spanish.mode')} value="informal"/>
        Informal</label>
        </fieldset>
      </div>
    ];
  }
}
