import { __ } from '@wordpress/i18n';
import { URLInput } from '@wordpress/editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';

export const ButtonOptions = (props) => {
  const {
    url,
    onChangeUrl,
    styleSize,
    onChangeStyleSize,
    styleColor,
    onChangeStyleColor,
    styleSizeWidth,
    onChangeStyleSizeWidth,
    id,
    onChangeId,
  } = props;

  return (
    <PanelBody title={__('Button Details', 'znanje-za-buducnost')}>

      {styleColor &&
        <SelectControl
          label={__('Button Color', 'znanje-za-buducnost')}
          value={styleColor}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
            { label: __('Primary', 'znanje-za-buducnost'), value: 'primary' },
          ]}
          onChange={onChangeStyleColor}
        />
      }

      {styleSize &&
        <SelectControl
          label={__('Button Size', 'znanje-za-buducnost')}
          value={styleSize}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
            { label: __('Big', 'znanje-za-buducnost'), value: 'big' },
          ]}
          onChange={onChangeStyleSize}
        />
      }

      {styleSizeWidth &&
        <SelectControl
          label={__('Button Size Width', 'znanje-za-buducnost')}
          value={styleSizeWidth}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
            { label: __('Block', 'znanje-za-buducnost'), value: 'block' },
          ]}
          onChange={onChangeStyleSizeWidth}
        />
      }

      {onChangeUrl &&
        <div>
          <label htmlFor="url">{__('Button Link', 'znanje-za-buducnost')}</label>
          <URLInput
            value={url}
            onChange={onChangeUrl}
          />
          <br />
        </div>
      }

      {onChangeId &&
        <div>
          <TextControl
            label={__('Button ID', 'znanje-za-buducnost')}
            value={id}
            onChange={onChangeId}
          />
        </div>
      }

    </PanelBody>
  );
};
