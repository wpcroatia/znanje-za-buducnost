import { __ } from '@wordpress/i18n';
import { PanelBody, SelectControl } from '@wordpress/components';

export const HeadingOptions = (props) => {
  const {
    styleColor,
    onChangeStyleColor,
    styleSize,
    onChangeStyleSize,
  } = props;

  return (
    <PanelBody title={__('Heading Details', 'znanje-za-buducnost')}>

      {styleColor &&
        <SelectControl
          label={__('Heading Color', 'znanje-za-buducnost')}
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
          label={__('Heading Size', 'znanje-za-buducnost')}
          value={styleSize}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
            { label: __('Big', 'znanje-za-buducnost'), value: 'big' },
          ]}
          onChange={onChangeStyleSize}
        />
      }

    </PanelBody>
  );
};
