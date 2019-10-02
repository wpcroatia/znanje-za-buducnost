import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl, SelectControl, ToggleControl } from '@wordpress/components';

export const WrapperOptions = (props) => {
  const {
    attributes: {
      styleBackgroundColor,
      styleTextColor,
      styleContentWidth,
      styleContentOffset,
      styleContainerWidth,
      styleContainerSpacing,
      styleSpacingTop,
      styleSpacingTopTablet,
      styleSpacingTopMobile,
      styleSpacingBottom,
      styleSpacingBottomTablet,
      styleSpacingBottomMobile,
      styleShowOnlyMobile,
      id,
    },
    actions: {
      onChangeStyleBackgroundColor,
      onChangeStyleTextColor,
      onChangeStyleContentWidth,
      onChangeStyleContentOffset,
      onChangeStyleContainerWidth,
      onChangeStyleContainerSpacing,
      onChangeStyleSpacingTop,
      onChangeStyleSpacingTopTablet,
      onChangeStyleSpacingTopMobile,
      onChangeStyleSpacingBottom,
      onChangeStyleSpacingBottomTablet,
      onChangeStyleSpacingBottomMobile,
      onChangeStyleShowOnlyMobile,
      onChangeId,
    },
  } = props;

  const maxCols = 12;
  const colsOutput = [];

  for (let index = 1; index <= maxCols; index++) {
    colsOutput.push({ label: `${index} - (${Math.round((100 / maxCols) * index)}%)`, value: index });
  }

  const spacingOptions = [
    { label: __('Not Set', 'znanje-za-buducnost'), value: '' },
    { label: __('Biggest (100px)', 'znanje-za-buducnost'), value: 'biggest' },
    { label: __('Bigger (90px)', 'znanje-za-buducnost'), value: 'bigger' },
    { label: __('Big (80px)', 'znanje-za-buducnost'), value: 'big' },
    { label: __('Largest (70px)', 'znanje-za-buducnost'), value: 'largest' },
    { label: __('Larger (60px)', 'znanje-za-buducnost'), value: 'larger' },
    { label: __('Large (50px)', 'znanje-za-buducnost'), value: 'large' },
    { label: __('Default (40px)', 'znanje-za-buducnost'), value: 'default' },
    { label: __('Medium (30px)', 'znanje-za-buducnost'), value: 'medium' },
    { label: __('Small (20px)', 'znanje-za-buducnost'), value: 'small' },
    { label: __('Tiny (10px)', 'znanje-za-buducnost'), value: 'tiny' },
    { label: __('No padding (0px)', 'znanje-za-buducnost'), value: 'no-spacing' },
  ];

  return (
    <PanelBody title={__('Utility', 'znanje-za-buducnost')}>
      <h3>{__('Colors', 'znanje-za-buducnost')}</h3>

      {onChangeStyleBackgroundColor &&
        <SelectControl
          label={__('Background Color', 'znanje-za-buducnost')}
          value={styleBackgroundColor}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
            { label: __('Primary', 'znanje-za-buducnost'), value: 'primary' },
            { label: __('Black', 'znanje-za-buducnost'), value: 'black' },
          ]}
          onChange={onChangeStyleBackgroundColor}
        />
      }

      {onChangeStyleTextColor &&
        <SelectControl
          label={__('Text Color', 'znanje-za-buducnost')}
          value={styleTextColor}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
          ]}
          onChange={onChangeStyleTextColor}
        />
      }

      <hr />
      <h3>{__('Content', 'znanje-za-buducnost')}</h3>

      {onChangeStyleContentWidth &&
        <SelectControl
          label={__('Content Width', 'znanje-za-buducnost')}
          value={styleContentWidth}
          options={colsOutput}
          onChange={onChangeStyleContentWidth}
        />
      }

      {onChangeStyleContentOffset &&
        <SelectControl
          label={__('Content Offset', 'znanje-za-buducnost')}
          value={styleContentOffset}
          options={[
            { label: __('No offset', 'znanje-za-buducnost'), value: 'none' },
            { label: __('Center', 'znanje-za-buducnost'), value: 'center' },
          ]}
          onChange={onChangeStyleContentOffset}
        />
      }

      <hr />
      <h3>{__('Container', 'znanje-za-buducnost')}</h3>
      {onChangeStyleContainerWidth &&
        <SelectControl
          label={__('Container Width', 'znanje-za-buducnost')}
          value={styleContainerWidth}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
            { label: __('Medium', 'znanje-za-buducnost'), value: 'medium' },
            { label: __('No Width', 'znanje-za-buducnost'), value: 'no-width' },
          ]}
          onChange={onChangeStyleContainerWidth}
        />
      }

      {onChangeStyleContainerSpacing &&
        <SelectControl
          label={__('Container Spacing', 'znanje-za-buducnost')}
          value={styleContainerSpacing}
          options={[
            { label: __('Default', 'znanje-za-buducnost'), value: 'default' },
            { label: __('No Spacing', 'znanje-za-buducnost'), value: 'no-spacing' },
          ]}
          onChange={onChangeStyleContainerSpacing}
        />
      }

      <hr />
      <h3>{__('Spacing TOP', 'znanje-za-buducnost')}</h3>

      {onChangeStyleSpacingTop &&
        <SelectControl
          label={__('Desktop', 'znanje-za-buducnost')}
          value={styleSpacingTop}
          options={spacingOptions}
          onChange={onChangeStyleSpacingTop}
        />
      }

      {onChangeStyleSpacingTopTablet &&
        <SelectControl
          label={__('Tablet', 'znanje-za-buducnost')}
          value={styleSpacingTopTablet}
          options={spacingOptions}
          onChange={onChangeStyleSpacingTopTablet}
        />
      }

      {onChangeStyleSpacingTopMobile &&
        <SelectControl
          label={__('Mobile', 'znanje-za-buducnost')}
          value={styleSpacingTopMobile}
          options={spacingOptions}
          onChange={onChangeStyleSpacingTopMobile}
        />
      }

      <hr />
      <h3>{__('Spacing BOTTOM', 'znanje-za-buducnost')}</h3>
      {onChangeStyleSpacingBottom &&
        <SelectControl
          label={__('Desktop', 'znanje-za-buducnost')}
          value={styleSpacingBottom}
          options={spacingOptions}
          onChange={onChangeStyleSpacingBottom}
        />
      }

      {onChangeStyleSpacingBottomTablet &&
        <SelectControl
          label={__('Tablet', 'znanje-za-buducnost')}
          value={styleSpacingBottomTablet}
          options={spacingOptions}
          onChange={onChangeStyleSpacingBottomTablet}
        />
      }

      {onChangeStyleSpacingBottomMobile &&
        <SelectControl
          label={__('Mobile', 'znanje-za-buducnost')}
          value={styleSpacingBottomMobile}
          options={spacingOptions}
          onChange={onChangeStyleSpacingBottomMobile}
        />
      }

      <hr />
      <h3>{__('Visibility', 'znanje-za-buducnost')}</h3>
      {onChangeStyleShowOnlyMobile &&
        <ToggleControl
          label={__('Show Block Only On Mobile', 'znanje-za-buducnost')}
          checked={styleShowOnlyMobile}
          onChange={onChangeStyleShowOnlyMobile}
        />
      }
      
      <hr />
      <h3>{__('General', 'znanje-za-buducnost')}</h3>
      {onChangeId &&
        <TextControl
          label={__('Section ID', 'znanje-za-buducnost')}
          value={id}
          onChange={onChangeId}
        />
      }
    </PanelBody>
  );
};
