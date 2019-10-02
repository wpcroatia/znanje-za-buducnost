import { __ } from '@wordpress/i18n';
import { URLInput } from '@wordpress/editor';
import { PanelBody, SelectControl } from '@wordpress/components';

export const LinkOptions = (props) => {
  const {
    url,
    onChangeUrl,
    styleColor,
    onChangeColor,
  } = props;

  return (
    <PanelBody title={__('Link Details', 'znanje-za-buducnost')}>

      {styleColor &&
        <SelectControl
          label={__('Link Color', 'znanje-za-buducnost')}
          value={styleColor}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
          ]}
          onChange={onChangeColor}
        />
      }

      {onChangeUrl &&
        <div>
          <label htmlFor="url">{__('Link Url', 'znanje-za-buducnost')}</label>
          <URLInput
            value={url}
            onChange={onChangeUrl}
          />
        </div>
      }

    </PanelBody>
  );
};
