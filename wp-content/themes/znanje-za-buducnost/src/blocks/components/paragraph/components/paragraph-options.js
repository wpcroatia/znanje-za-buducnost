import { Fragment } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { PanelBody, SelectControl } from '@wordpress/components';

export const ParagraphOptions = (props) => {
  const {
    styleColor,
    onChangeStyleColor,
    removeStyle,
  } = props;

  return (
    <Fragment>
      {removeStyle !== true &&
        <PanelBody title={__('Paragraph Details', 'znanje-za-buducnost')}>

          {styleColor &&
            <SelectControl
              label={__('Paragraph Color', 'znanje-za-buducnost')}
              value={styleColor}
              options={[
                { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
                { label: __('Primary', 'znanje-za-buducnost'), value: 'primary' },
              ]}
              onChange={onChangeStyleColor}
            />
          }
        </PanelBody>
      }
    </Fragment>
  );
};

